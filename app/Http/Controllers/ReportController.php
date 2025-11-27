<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Purchase;
use App\Models\Expense;
use App\Models\SaleItem;
use Carbon\Carbon;

class ReportController extends Controller
{
  public function index(Request $request)
  {
    // Tentukan periode
    $period = $request->get('period', 'today');
    $startDate = $request->get('start_date');
    $endDate = $request->get('end_date');

    if ($startDate && $endDate) {
      $start = Carbon::parse($startDate)->startOfDay();
      $end = Carbon::parse($endDate)->endOfDay();
    } else {
      switch ($period) {
        case 'today':
          $start = Carbon::today();
          $end = Carbon::today();
          break;
        case 'yesterday':
          $start = Carbon::yesterday();
          $end = Carbon::yesterday();
          break;
        case 'week':
          $start = Carbon::now()->startOfWeek();
          $end = Carbon::now()->endOfWeek();
          break;
        case 'month':
          $start = Carbon::now()->startOfMonth();
          $end = Carbon::now()->endOfMonth();
          break;
        case 'year':
          $start = Carbon::now()->startOfYear();
          $end = Carbon::now()->endOfYear();
          break;
        default:
          $start = Carbon::today();
          $end = Carbon::today();
      }
    }

    // Ambil data keuangan
    $totalRevenue = Sale::whereBetween('sale_date', [$start, $end])->sum('total_amount');
    $totalPurchases = Purchase::whereBetween('purchase_date', [$start, $end])->sum('total_cost');
    $totalExpenses = Expense::whereBetween('expense_date', [$start, $end])->sum('amount');
    $netProfit = $totalRevenue - $totalPurchases - $totalExpenses;

    // Data trend (harian/bulanan/tahunan)
    $trendData = $this->getTrendData($start, $end);

    // Top 5 ikan terlaris
    $topFish = SaleItem::selectRaw('fish_id, SUM(quantity) as qty, SUM(subtotal) as revenue')
      ->whereHas('sale', fn($q) => $q->whereBetween('sale_date', [$start, $end]))
      ->with('fish:id,name')
      ->groupBy('fish_id')
      ->orderByDesc('revenue')
      ->limit(5)
      ->get()
      ->map(fn($item) => [
        'name' => $item->fish->name,
        'revenue' => $item->revenue,
      ]);

    // Breakdown pengeluaran
    $expenseBreakdown = Expense::selectRaw('category, SUM(amount) as total')
      ->whereBetween('expense_date', [$start, $end])
      ->groupBy('category')
      ->pluck('total', 'category')
      ->toArray();

    // Summary untuk bar chart
    $summaryData = [
      'revenue' => $totalRevenue,
      'purchases' => $totalPurchases,
      'expenses' => $totalExpenses,
      'profit' => $netProfit,
    ];

    // Kirim semua data ke view
    return view('reports.index', compact(
      'totalRevenue',
      'totalPurchases',
      'totalExpenses',
      'netProfit',
      'summaryData',
      'trendData',
      'topFish',
      'expenseBreakdown',
      'start',
      'end'
    ));
  }

  private function getTrendData($start, $end)
  {
    $daysDiff = $start->diffInDays($end);

    if ($daysDiff <= 31) {
      // Harian
      $dates = [];
      $current = $start->copy();
      while ($current <= $end) {
        $dates[] = $current->format('d M');
        $current->addDay();
      }

      $sales = Sale::whereBetween('sale_date', [$start, $end])
        ->selectRaw('DATE(sale_date) as date, SUM(total_amount) as total')
        ->groupBy('date')
        ->pluck('total', 'date');

      $expenses = Expense::whereBetween('expense_date', [$start, $end])
        ->selectRaw('DATE(expense_date) as date, SUM(amount) as total')
        ->groupBy('date')
        ->pluck('total', 'date');

      return collect($dates)->map(function ($date, $i) use ($start, $sales, $expenses) {
        $d = $start->copy()->addDays($i)->format('Y-m-d');
        return [
          'date' => $date,
          'sales' => $sales[$d] ?? 0,
          'expenses' => $expenses[$d] ?? 0,
        ];
      })->toArray();
    } elseif ($daysDiff <= 365) {
      // Bulanan
      $months = [];
      $current = $start->copy()->startOfMonth();
      while ($current <= $end) {
        $months[] = $current->format('M Y');
        $current->addMonth();
      }

      $sales = Sale::whereBetween('sale_date', [$start, $end])
        ->selectRaw('YEAR(sale_date) as y, MONTH(sale_date) as m, SUM(total_amount) as total')
        ->groupBy('y', 'm')
        ->get()
        ->mapWithKeys(fn($row) => ["{$row->y}-{$row->m}" => $row->total]);

      $expenses = Expense::whereBetween('expense_date', [$start, $end])
        ->selectRaw('YEAR(expense_date) as y, MONTH(expense_date) as m, SUM(amount) as total')
        ->groupBy('y', 'm')
        ->get()
        ->mapWithKeys(fn($row) => ["{$row->y}-{$row->m}" => $row->total]);

      return collect($months)->map(function ($month, $i) use ($start, $sales, $expenses) {
        $m = $start->copy()->addMonths($i)->format('Y-n');
        return [
          'date' => $month,
          'sales' => $sales[$m] ?? 0,
          'expenses' => $expenses[$m] ?? 0,
        ];
      })->toArray();
    } else {
      // Tahunan
      $years = [];
      $current = $start->copy()->startOfYear();
      while ($current <= $end) {
        $years[] = $current->format('Y');
        $current->addYear();
      }

      $sales = Sale::whereBetween('sale_date', [$start, $end])
        ->selectRaw('YEAR(sale_date) as y, SUM(total_amount) as total')
        ->groupBy('y')
        ->pluck('total', 'y');

      $expenses = Expense::whereBetween('expense_date', [$start, $end])
        ->selectRaw('YEAR(expense_date) as y, SUM(amount) as total')
        ->groupBy('y')
        ->pluck('total', 'y');

      return collect($years)->map(function ($year, $i) use ($start, $sales, $expenses) {
        $y = $start->copy()->addYears($i)->format('Y');
        return [
          'date' => $year,
          'sales' => $sales[$y] ?? 0,
          'expenses' => $expenses[$y] ?? 0,
        ];
      })->toArray();
    }
  }
}

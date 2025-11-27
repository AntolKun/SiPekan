<?php

namespace App\Http\Controllers;

use App\Models\Fish;
use App\Models\Sale;
use App\Models\Purchase;
use App\Models\Expense;
use App\Models\Customer;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
  public function index()
  {
    // Date ranges
    $today = Carbon::today();
    $thisWeekStart = Carbon::now()->startOfWeek();
    $thisMonthStart = Carbon::now()->startOfMonth();

    // === SUMMARY CARDS ===

    // Total Sales (All time)
    $totalSales = Sale::sum('total_amount');

    // Today's Sales
    $todaySales = Sale::whereDate('sale_date', $today)->sum('total_amount');

    // Total Stock Value
    $totalStockValue = Fish::sum(DB::raw('stock * selling_price'));

    // Low Stock Count
    $lowStockCount = Fish::where('stock', '<=', 10)
      ->where('stock', '>', 0)
      ->count();

    // This Month Profit (Revenue - Expenses - Purchase Costs)
    $monthRevenue = Sale::whereYear('sale_date', $today->year)
      ->whereMonth('sale_date', $today->month)
      ->sum('total_amount');

    $monthExpenses = Expense::whereYear('expense_date', $today->year)
      ->whereMonth('expense_date', $today->month)
      ->sum('amount');

    $monthPurchases = Purchase::whereYear('purchase_date', $today->year)
      ->whereMonth('purchase_date', $today->month)
      ->sum('total_cost');

    $monthProfit = $monthRevenue - $monthExpenses - $monthPurchases;

    // Today's Expenses
    $todayExpenses = Expense::whereDate('expense_date', $today)->sum('amount');

    // === TOP SELLING FISH ===
    $topSellingFish = DB::table('sale_items')
      ->join('fish', 'sale_items.fish_id', '=', 'fish.id')
      ->select(
        'fish.id',
        'fish.name',
        'fish.photo',
        'fish.stock',
        DB::raw('SUM(sale_items.quantity) as total_sold'),
        DB::raw('SUM(sale_items.subtotal) as total_revenue')
      )
      ->groupBy('fish.id', 'fish.name', 'fish.photo', 'fish.stock')
      ->orderBy('total_sold', 'desc')
      ->limit(5)
      ->get();

    // === WEEKLY SALES CHART ===
    $weeklySales = [];
    $weekDays = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];

    for ($i = 0; $i < 7; $i++) {
      $date = Carbon::now()->startOfWeek()->addDays($i);
      $amount = Sale::whereDate('sale_date', $date)->sum('total_amount');

      $weeklySales[] = [
        'day' => $weekDays[$i],
        'date' => $date->format('d M'),
        'amount' => $amount
      ];
    }

    // === LOW STOCK ALERTS ===
    $lowStockFish = Fish::where('stock', '<=', 10)
      ->where('stock', '>', 0)
      ->orderBy('stock', 'asc')
      ->limit(5)
      ->get();

    // === RECENT ACTIVITIES ===

    // Recent Sales
    $recentSales = Sale::with(['customer', 'items.fish'])
      ->orderBy('sale_date', 'desc')
      ->limit(5)
      ->get()
      ->map(function ($sale) {
        return [
          'type' => 'sale',
          'icon' => '💰',
          'color' => 'green',
          'title' => 'Penjualan',
          'description' => ($sale->customer ? $sale->customer->name : 'Pelanggan Umum') . ' - ' . $sale->items->count() . ' item',
          'amount' => $sale->total_amount,
          'date' => $sale->sale_date,
          'url' => route('sales.show', $sale->id)
        ];
      });

    // Recent Purchases
    $recentPurchases = Purchase::with(['supplier', 'fish'])
      ->orderBy('purchase_date', 'desc')
      ->limit(5)
      ->get()
      ->map(function ($purchase) {
        return [
          'type' => 'purchase',
          'icon' => '📦',
          'color' => 'blue',
          'title' => 'Pembelian',
          'description' => $purchase->supplier->name . ' - ' . $purchase->fish->name,
          'amount' => $purchase->total_cost,
          'date' => $purchase->purchase_date,
          'url' => route('purchases.show', $purchase->id)
        ];
      });

    // Recent Expenses
    $recentExpenses = Expense::orderBy('expense_date', 'desc')
      ->limit(5)
      ->get()
      ->map(function ($expense) {
        return [
          'type' => 'expense',
          'icon' => '💸',
          'color' => 'orange',
          'title' => 'Pengeluaran',
          'description' => $expense->description,
          'amount' => $expense->amount,
          'date' => $expense->expense_date,
          'url' => route('expenses.edit', $expense->id)
        ];
      });

    // Merge and sort activities by date
    $recentActivities = collect()
      ->merge($recentSales)
      ->merge($recentPurchases)
      ->merge($recentExpenses)
      ->sortByDesc('date')
      ->take(8)
      ->values();

    // === ADDITIONAL STATS ===
    $totalCustomers = Customer::count();
    $totalSuppliers = Supplier::count();
    $totalFishTypes = Fish::count();
    $todayTransactions = Sale::whereDate('sale_date', $today)->count();

    return view('dashboard', compact(
      'totalSales',
      'todaySales',
      'totalStockValue',
      'lowStockCount',
      'monthProfit',
      'todayExpenses',
      'topSellingFish',
      'weeklySales',
      'lowStockFish',
      'recentActivities',
      'totalCustomers',
      'totalSuppliers',
      'totalFishTypes',
      'todayTransactions'
    ));
  }
}

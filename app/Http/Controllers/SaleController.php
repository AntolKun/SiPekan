<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Fish;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
  public function index()
  {
    $sales = Sale::with(['customer', 'items.fish'])
      ->orderBy('sale_date', 'desc')
      ->paginate(20);

    return view('sales.index', compact('sales'));
  }

  public function create()
  {
    $fish = Fish::where('stock', '>', 0)
      ->where('health_status', 'sehat')
      ->orderBy('name')
      ->get();

    $customers = Customer::orderBy('name')->get();

    return view('sales.create', compact('fish', 'customers'));
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'customer_id' => 'nullable|exists:customers,id',
      'sale_date' => 'required|date',
      'payment_method' => 'required|in:cash,transfer,qris',
      'discount' => 'nullable|numeric|min:0',
      'notes' => 'nullable|string',
      'items' => 'required|array|min:1',
      'items.*.fish_id' => 'required|exists:fish,id',
      'items.*.quantity' => 'required|integer|min:1',
      'items.*.price' => 'required|numeric|min:0',
    ]);

    DB::beginTransaction();
    try {
      $totalAmount = 0;

      // Calculate total
      foreach ($request->items as $item) {
        $totalAmount += $item['quantity'] * $item['price'];
      }

      // Create sale
      $sale = Sale::create([
        'customer_id' => $request->customer_id,
        'sale_date' => $request->sale_date,
        'total_amount' => $totalAmount - ($request->discount ?? 0),
        'discount' => $request->discount ?? 0,
        'payment_method' => $request->payment_method,
        'notes' => $request->notes,
      ]);

      // Create sale items and update stock
      foreach ($request->items as $item) {
        $fish = Fish::findOrFail($item['fish_id']);

        // Check stock
        if ($fish->stock < $item['quantity']) {
          throw new \Exception("Stok {$fish->name} tidak mencukupi! Stok tersedia: {$fish->stock} ekor");
        }

        // Create sale item
        SaleItem::create([
          'sale_id' => $sale->id,
          'fish_id' => $item['fish_id'],
          'quantity' => $item['quantity'],
          'price' => $item['price'],
          'subtotal' => $item['quantity'] * $item['price'],
        ]);

        // ✅ UPDATE STOCK - Kurangi stok
        $fish->decrement('stock', $item['quantity']);
      }

      // Update customer purchase count
      if ($request->customer_id) {
        Customer::find($request->customer_id)->increment('purchase_count');
      }

      DB::commit();

      return redirect()->route('sales.index')
        ->with('success', '✅ Penjualan berhasil disimpan dan stok telah diperbarui!');
    } catch (\Exception $e) {
      DB::rollBack();
      return back()->withInput()->withErrors(['error' => $e->getMessage()]);
    }
  }

  public function show(Sale $sale)
  {
    $sale->load(['customer', 'items.fish']);
    return view('sales.show', compact('sale'));
  }

  public function destroy(Sale $sale)
  {
    DB::beginTransaction();
    try {
      // Kembalikan stok sebelum hapus
      foreach ($sale->items as $item) {
        $fish = $item->fish;
        if ($fish) {
          $fish->increment('stock', $item->quantity);
        }
      }

      // Update customer purchase count
      if ($sale->customer_id) {
        Customer::find($sale->customer_id)->decrement('purchase_count');
      }

      $sale->delete();

      DB::commit();

      return redirect()->route('sales.index')
        ->with('success', '✅ Transaksi berhasil dihapus dan stok dikembalikan!');
    } catch (\Exception $e) {
      DB::rollBack();
      return back()->withErrors(['error' => $e->getMessage()]);
    }
  }
}

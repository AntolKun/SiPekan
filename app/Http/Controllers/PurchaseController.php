<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Fish;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
  public function index()
  {
    $purchases = Purchase::with(['supplier', 'fish'])
      ->orderBy('purchase_date', 'desc')
      ->paginate(20);

    $monthlyTotal = Purchase::whereMonth('purchase_date', now()->month)
      ->whereYear('purchase_date', now()->year)
      ->sum('total_cost');

    return view('purchases.index', compact('purchases', 'monthlyTotal'));
  }

  public function create(Request $request)
  {
    $fish = Fish::orderBy('name')->get();
    $suppliers = Supplier::orderBy('name')->get();

    // Jika ada fish_id dari parameter (dari halaman stok)
    $selectedFishId = $request->get('fish_id');

    return view('purchases.create', compact('fish', 'suppliers', 'selectedFishId'));
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'supplier_id' => 'required|exists:suppliers,id',
      'fish_id' => 'required|exists:fish,id',
      'quantity' => 'required|integer|min:1',
      'price_per_unit' => 'required|numeric|min:0',
      'transport_cost' => 'nullable|numeric|min:0',
      'purchase_date' => 'required|date',
    ]);

    DB::beginTransaction();
    try {
      // Create purchase record
      $purchase = Purchase::create([
        'supplier_id' => $validated['supplier_id'],
        'fish_id' => $validated['fish_id'],
        'quantity' => $validated['quantity'],
        'price_per_unit' => $validated['price_per_unit'],
        'transport_cost' => $validated['transport_cost'] ?? 0,
        'purchase_date' => $validated['purchase_date'],
      ]);

      // Update fish stock
      $fish = Fish::findOrFail($validated['fish_id']);
      $fish->increment('stock', $validated['quantity']);

      // Update purchase price if needed
      $fish->update([
        'purchase_price' => $validated['price_per_unit']
      ]);

      DB::commit();

      return redirect()->route('purchases.index')
        ->with('success', 'Pembelian berhasil dicatat dan stok telah diupdate!');
    } catch (\Exception $e) {
      DB::rollBack();
      return back()->withInput()->withErrors(['error' => $e->getMessage()]);
    }
  }

  public function show(Purchase $purchase)
  {
    $purchase->load(['supplier', 'fish']);
    return view('purchases.show', compact('purchase'));
  }

  public function edit(Purchase $purchase)
  {
    $fish = Fish::orderBy('name')->get();
    $suppliers = Supplier::orderBy('name')->get();

    return view('purchases.edit', compact('purchase', 'fish', 'suppliers'));
  }

  public function update(Request $request, Purchase $purchase)
  {
    $validated = $request->validate([
      'supplier_id' => 'required|exists:suppliers,id',
      'fish_id' => 'required|exists:fish,id',
      'quantity' => 'required|integer|min:1',
      'price_per_unit' => 'required|numeric|min:0',
      'transport_cost' => 'nullable|numeric|min:0',
      'purchase_date' => 'required|date',
    ]);

    DB::beginTransaction();
    try {
      $oldQuantity = $purchase->quantity;
      $oldFishId = $purchase->fish_id;

      // Kembalikan stok lama
      if ($oldFishId) {
        $oldFish = Fish::find($oldFishId);
        if ($oldFish) {
          $oldFish->decrement('stock', $oldQuantity);
        }
      }

      // Update purchase
      $purchase->update([
        'supplier_id' => $validated['supplier_id'],
        'fish_id' => $validated['fish_id'],
        'quantity' => $validated['quantity'],
        'price_per_unit' => $validated['price_per_unit'],
        'transport_cost' => $validated['transport_cost'] ?? 0,
        'purchase_date' => $validated['purchase_date'],
      ]);

      // Update stok baru
      $fish = Fish::findOrFail($validated['fish_id']);
      $fish->increment('stock', $validated['quantity']);

      DB::commit();

      return redirect()->route('purchases.index')
        ->with('success', 'Data pembelian berhasil diupdate!');
    } catch (\Exception $e) {
      DB::rollBack();
      return back()->withInput()->withErrors(['error' => $e->getMessage()]);
    }
  }

  public function destroy(Purchase $purchase)
  {
    DB::beginTransaction();
    try {
      // Kembalikan stok
      $fish = $purchase->fish;
      if ($fish) {
        $fish->decrement('stock', $purchase->quantity);
      }

      $purchase->delete();

      DB::commit();

      return redirect()->route('purchases.index')
        ->with('success', 'Data pembelian berhasil dihapus!');
    } catch (\Exception $e) {
      DB::rollBack();
      return back()->withErrors(['error' => $e->getMessage()]);
    }
  }
}

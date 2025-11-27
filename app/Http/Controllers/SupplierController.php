<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
  public function index(Request $request)
  {
    $query = Supplier::query();

    // Search functionality
    if ($request->has('search')) {
      $search = $request->get('search');
      $query->where(function ($q) use ($search) {
        $q->where('name', 'like', "%{$search}%")
          ->orWhere('contact', 'like', "%{$search}%");
      });
    }

    $suppliers = $query->withCount('purchases')
      ->withSum('purchases', 'total_cost')
      ->orderBy('name')
      ->paginate(20);

    $totalSuppliers = Supplier::count();
    $activeSuppliers = Supplier::has('purchases')->count();

    return view('suppliers.index', compact('suppliers', 'totalSuppliers', 'activeSuppliers'));
  }

  public function create()
  {
    return view('suppliers.create');
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'name' => 'required|string|max:255',
      'contact' => 'nullable|string|max:100',
      'address' => 'nullable|string',
      'survival_rate' => 'nullable|numeric|min:0|max:100',
    ]);

    Supplier::create($validated);

    return redirect()->route('suppliers.index')
      ->with('success', 'Supplier berhasil ditambahkan!');
  }

  public function show(Supplier $supplier)
  {
    $supplier->load(['purchases' => function ($query) {
      $query->with('fish')->latest('purchase_date');
    }]);

    $totalPurchase = $supplier->purchases->sum('total_cost');
    $totalQuantity = $supplier->purchases->sum('quantity');
    $lastPurchase = $supplier->purchases->first();

    return view('suppliers.show', compact('supplier', 'totalPurchase', 'totalQuantity', 'lastPurchase'));
  }

  public function edit(Supplier $supplier)
  {
    return view('suppliers.edit', compact('supplier'));
  }

  public function update(Request $request, Supplier $supplier)
  {
    $validated = $request->validate([
      'name' => 'required|string|max:255',
      'contact' => 'nullable|string|max:100',
      'address' => 'nullable|string',
      'survival_rate' => 'nullable|numeric|min:0|max:100',
    ]);

    $supplier->update($validated);

    return redirect()->route('suppliers.index')
      ->with('success', 'Data supplier berhasil diupdate!');
  }

  public function destroy(Supplier $supplier)
  {
    // Check if supplier has purchases
    if ($supplier->purchases()->count() > 0) {
      return back()->withErrors(['error' => 'Tidak dapat menghapus supplier yang sudah memiliki transaksi pembelian!']);
    }

    $supplier->delete();

    return redirect()->route('suppliers.index')
      ->with('success', 'Supplier berhasil dihapus!');
  }
}

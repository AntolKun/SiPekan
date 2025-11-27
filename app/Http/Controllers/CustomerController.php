<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
  public function index(Request $request)
  {
    $query = Customer::query();

    // Search functionality
    if ($request->has('search')) {
      $search = $request->get('search');
      $query->where(function ($q) use ($search) {
        $q->where('name', 'like', "%{$search}%")
          ->orWhere('phone', 'like', "%{$search}%");
      });
    }

    $customers = $query->orderBy('name')->paginate(20);

    $totalCustomers = Customer::count();
    $activeCustomers = Customer::where('purchase_count', '>', 0)->count();

    return view('customers.index', compact('customers', 'totalCustomers', 'activeCustomers'));
  }

  public function create()
  {
    return view('customers.create');
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'name' => 'required|string|max:255',
      'phone' => 'nullable|string|max:20',
      'address' => 'nullable|string',
    ]);

    Customer::create($validated);

    return redirect()->route('customers.index')
      ->with('success', 'Pelanggan berhasil ditambahkan!');
  }

  public function show(Customer $customer)
  {
    $customer->load(['sales' => function ($query) {
      $query->with('items.fish')->latest('sale_date');
    }]);

    $totalPurchase = $customer->sales->sum('total_amount');
    $lastPurchase = $customer->sales->first();

    return view('customers.show', compact('customer', 'totalPurchase', 'lastPurchase'));
  }

  public function edit(Customer $customer)
  {
    return view('customers.edit', compact('customer'));
  }

  public function update(Request $request, Customer $customer)
  {
    $validated = $request->validate([
      'name' => 'required|string|max:255',
      'phone' => 'nullable|string|max:20',
      'address' => 'nullable|string',
    ]);

    $customer->update($validated);

    return redirect()->route('customers.index')
      ->with('success', 'Data pelanggan berhasil diupdate!');
  }

  public function destroy(Customer $customer)
  {
    // Check if customer has sales
    if ($customer->sales()->count() > 0) {
      return back()->withErrors(['error' => 'Tidak dapat menghapus pelanggan yang sudah memiliki transaksi!']);
    }

    $customer->delete();

    return redirect()->route('customers.index')
      ->with('success', 'Pelanggan berhasil dihapus!');
  }
}

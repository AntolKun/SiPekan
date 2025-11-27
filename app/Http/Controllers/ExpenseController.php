<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
  public function index()
  {
    $expenses = Expense::orderBy('expense_date', 'desc')
      ->paginate(20);

    $monthlyTotal = Expense::whereMonth('expense_date', now()->month)
      ->whereYear('expense_date', now()->year)
      ->sum('amount');

    return view('expenses.index', compact('expenses', 'monthlyTotal'));
  }

  public function create()
  {
    return view('expenses.create');
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'category' => 'required|in:pakan,listrik,air_treatment,gaji,sewa,peralatan,maintenance,lainnya',
      'description' => 'required|string|max:255',
      'amount' => 'required|numeric|min:0',
      'expense_date' => 'required|date',
    ]);

    Expense::create($validated);

    return redirect()->route('expenses.index')
      ->with('success', 'Pengeluaran berhasil dicatat!');
  }

  public function edit(Expense $expense)
  {
    return view('expenses.edit', compact('expense'));
  }

  public function update(Request $request, Expense $expense)
  {
    $validated = $request->validate([
      'category' => 'required|in:pakan,listrik,air_treatment,gaji,sewa,peralatan,maintenance,lainnya',
      'description' => 'required|string|max:255',
      'amount' => 'required|numeric|min:0',
      'expense_date' => 'required|date',
    ]);

    $expense->update($validated);

    return redirect()->route('expenses.index')
      ->with('success', 'Pengeluaran berhasil diupdate!');
  }

  public function destroy(Expense $expense)
  {
    $expense->delete();

    return redirect()->route('expenses.index')
      ->with('success', 'Pengeluaran berhasil dihapus!');
  }
}

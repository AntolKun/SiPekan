<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FishController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\MortalityController;
use App\Http\Controllers\QuarantineController;
use App\Http\Controllers\ReportController;
// use App\Http\Controllers\Api\ReportController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Fish Management
Route::resource('fish', FishController::class);

// Sales
Route::resource('sales', SaleController::class);

// Purchases
Route::resource('purchases', PurchaseController::class);

// Expenses
Route::resource('expenses', ExpenseController::class);

// Customers
Route::resource('customers', CustomerController::class);

// Suppliers
Route::resource('suppliers', SupplierController::class);

// Mortality Records
Route::resource('mortality', MortalityController::class);

// Quarantine Records
Route::resource('quarantine', QuarantineController::class);
Route::post('/quarantine/{quarantine}/complete', [QuarantineController::class, 'complete'])
  ->name('quarantine.complete');

Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');
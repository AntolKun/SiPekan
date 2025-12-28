<?php

// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\DashboardController;
// use App\Http\Controllers\FishController;
// use App\Http\Controllers\SaleController;
// use App\Http\Controllers\PurchaseController;
// use App\Http\Controllers\ExpenseController;
// use App\Http\Controllers\CustomerController;
// use App\Http\Controllers\SupplierController;
// use App\Http\Controllers\MortalityController;
// use App\Http\Controllers\QuarantineController;
// use App\Http\Controllers\ReportController;
// use App\Http\Controllers\AuthController;
// // use App\Http\Controllers\Api\ReportController;

// Route::middleware('guest')->group(function () {
//   Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
//   Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
// });

// Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// // Fish Management
// Route::resource('fish', FishController::class);

// // Sales
// Route::resource('sales', SaleController::class);

// // Purchases
// Route::resource('purchases', PurchaseController::class);

// // Expenses
// Route::resource('expenses', ExpenseController::class);

// // Customers
// Route::resource('customers', CustomerController::class);

// // Suppliers
// Route::resource('suppliers', SupplierController::class);

// // Mortality Records
// Route::resource('mortality', MortalityController::class);

// // Quarantine Records
// Route::resource('quarantine', QuarantineController::class);
// Route::post('/quarantine/{quarantine}/complete', [QuarantineController::class, 'complete'])
//   ->name('quarantine.complete');

// Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
// Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Guest Routes (Login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Dashboard - All roles
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Routes untuk Kasir (kasir, admin, superadmin)
    Route::middleware('role:kasir,admin,superadmin')->group(function () {
        
        // Fish Stock (Read Only untuk kasir)
        Route::get('/fish', [FishController::class, 'index'])->name('fish.index');
        Route::get('/fish/{fish}', [FishController::class, 'show'])->name('fish.show');
        
        // Sales
        Route::resource('sales', SaleController::class);
        
        // Customers
        Route::resource('customers', CustomerController::class);
    });

    // Routes untuk Admin dan Superadmin
    Route::middleware('role:admin,superadmin')->group(function () {
        
        // Fish Management (Full CRUD)
        Route::get('/fish/create', [FishController::class, 'create'])->name('fish.create');
        Route::post('/fish', [FishController::class, 'store'])->name('fish.store');
        Route::get('/fish/{fish}/edit', [FishController::class, 'edit'])->name('fish.edit');
        Route::put('/fish/{fish}', [FishController::class, 'update'])->name('fish.update');
        Route::delete('/fish/{fish}', [FishController::class, 'destroy'])->name('fish.destroy');
        
        // Purchases
        Route::resource('purchases', PurchaseController::class);
        
        // Expenses
        Route::resource('expenses', ExpenseController::class);
        
        // Suppliers
        Route::resource('suppliers', SupplierController::class);
        
        // Mortality Records
        Route::resource('mortality', MortalityController::class);
        
        // Quarantine
        Route::resource('quarantine', QuarantineController::class);
        Route::post('/quarantine/{quarantine}/complete', [QuarantineController::class, 'complete'])->name('quarantine.complete');
        
        // Reports
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/profit-loss', [ReportController::class, 'profitLoss'])->name('reports.profit-loss');
        Route::get('/reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
        Route::get('/reports/stock', [ReportController::class, 'stock'])->name('reports.stock');

        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');
  });

    // Routes khusus Superadmin
    Route::middleware('role:superadmin')->group(function () {
        Route::get('/users', [AuthController::class, 'index'])->name('users.index');
        Route::get('/users/create', [AuthController::class, 'create'])->name('users.create');
        Route::post('/users', [AuthController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [AuthController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [AuthController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [AuthController::class, 'destroy'])->name('users.destroy');
    });
});
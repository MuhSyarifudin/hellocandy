<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\SalesDetailController;
use App\Http\Controllers\ReportDetailController;
use App\Http\Controllers\WeeklyReportController;
use App\Http\Controllers\ManajemenUserController;



Route::get('/', function () {
    return redirect()->route('login');
});
// Route untuk menampilkan halaman login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

// Route untuk memproses login
Route::post('/login', [AuthController::class, 'login']);

// Route untuk logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route yang memerlukan autentikasi
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'Dashboard']);
    Route::resource('sales', SaleController::class);
    Route::resource('sales-history', SalesDetailController::class);
    Route::resource('inventory', InventoryController::class);
    Route::resource('expenses', ExpenseController::class);
    Route::resource('daily-reports', ReportController::class);
    Route::resource('products', ProductController::class);
    Route::resource('users', ManajemenUserController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('reports', ReportDetailController::class);
    Route::get('reports/yearly-summary/{year?}', [ReportDetailController::class, 'yearlySummary'])
    ->name('reports.yearlySummary');
    Route::get('reports/pdf/{year}', [ReportDetailController::class, 'generatePdf'])->name('reports.pdf');

    // Route untuk Ekspor Excel
    Route::get('daily-reports/export-excel', [ReportController::class, 'exportExcel'])->name('daily-reports.exportExcel');

    // Route untuk Ekspor PDF
    Route::get('daily-reports/export-pdf', [ReportController::class, 'exportPdf'])->name('daily-reports.exportPdf');

    // Route untuk Import Data
    Route::post('daily-reports/import', [ReportController::class, 'import'])->name('daily-reports.import');

    Route::resource('weekly-reports', WeeklyReportController::class);


});
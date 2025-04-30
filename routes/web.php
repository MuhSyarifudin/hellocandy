<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\SalesDetailController;
use App\Http\Controllers\ReportDetailController;
use App\Http\Controllers\WeeklyReportController;
use App\Http\Controllers\ManajemenUserController;
use App\Http\Controllers\PaymentMethodController;



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
    Route::resource('partners', PartnerController::class)->middleware('auth');
    Route::resource('guest_orders', OrderController::class);
    Route::get('/guest_orders/{id}/nota', [OrderController::class, 'printNota'])->name('guest_orders.nota');
    Route::patch('/guest-orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('guest_orders.update_status');
    Route::patch('/guest_orders/{id}/update-payment-status', [OrderController::class, 'updatePaymentStatus'])->name('guest_orders.update_payment_status');
    Route::patch('/guest_orders/{id}/update-processing-status', [OrderController::class, 'updateProcessingStatus'])->name('guest_orders.update_processing_status');
    // Route untuk update partner pada guest order
    Route::patch('/guest_orders/{order}/update_partner', [OrderController::class, 'updatePartner'])->name('guest_orders.update_partner');
    Route::patch('/guest-orders/{id}/update-payment-method', [OrderController::class, 'updatePaymentMethod'])
    ->name('guest_orders.update_payment_method');


    Route::resource('sales', SaleController::class);
    Route::resource('sales-history', SalesDetailController::class);
    Route::get('sales-history/filter', [SalesDetailController::class, 'index'])->name('sales.history');
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
    Route::resource('payment_methods', PaymentMethodController::class);
    Route::get('/chart/revenue', [DashboardController::class, 'renderRevenueChart'])->name('chart.revenue');
    Route::get('/chart/expense', [DashboardController::class, 'renderExpenseChart'])->name('chart.expense');
});
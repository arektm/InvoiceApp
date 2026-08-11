<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    // Route::inertia('dashboard', 'Dashboard')->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('company', [CompanyController::class, 'index'])->name('company');
    Route::get('company/edit', [CompanyController::class, 'edit'])->name('editCompany');
    Route::patch('company/{company}', [CompanyController::class, 'update'])->name('updateCompany');

    //deleted invoices
    Route::get('/invoices/deleted', [InvoiceController::class, 'deleted'])->name('invoices.deleted');

    // export to pdf
    Route::get('/invoices/{invoice}/pdf', [InvoiceController::class, 'pdf'])->name('invoices.pdf');

    // print pdf
    Route::get('/invoices/{invoice}/print', [InvoiceController::class, 'print'])->name('invoices.print');

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/unpaid-invoices', [ReportController::class, 'unpaidInvoices'])->name('reports.unpaid-invoices');
    Route::get('/reports/overdue-invoices', [ReportController::class, 'overdueInvoices'])->name('reports.overdue-invoices');

    //Resource routes
    Route::resource('clients', ClientController::class);
    Route::resource('products', ProductController::class);
    Route::resource('invoices', InvoiceController::class);

});

require __DIR__.'/settings.php';

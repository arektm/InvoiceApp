<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


// Route::inertia('/', 'Welcome')->name('home');
Route::get('/', function () {
     if (Auth::check()) {
        return redirect()->route('company');
    }

    return redirect()->route('login');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    // Route::inertia('dashboard', 'Dashboard')->name('dashboard');
    Route::get('company', [CompanyController::class, 'index'])->name('company');
    Route::get('company/edit', [CompanyController::class, 'edit'])->name('editCompany');
    Route::patch('company/{company}', [CompanyController::class, 'update'])->name('updateCompany');

    Route::resource('clients', ClientController::class);
    Route::resource('products', ProductController::class);
    Route::resource('invoices', InvoiceController::class);



});

require __DIR__.'/settings.php';

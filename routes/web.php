<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


// Route::inertia('/', 'Welcome')->name('home');
Route::get('/', function () {
     if (Auth::check()) {
        return redirect()->route('start');
    }

    return redirect()->route('login');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    // Route::inertia('dashboard', 'Dashboard')->name('dashboard');
    Route::inertia('start', 'Start')->name('start');
});

require __DIR__.'/settings.php';

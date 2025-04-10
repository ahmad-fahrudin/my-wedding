<?php

use App\Http\Controllers\UndanganController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Undangan Routes
Route::get('/undangans', [UndanganController::class, 'index'])->name('undangans.index');
Route::get('/undangans/create', [UndanganController::class, 'create'])->name('undangans.create');
Route::post('/undangans', [UndanganController::class, 'store'])->name('undangans.store');
Route::get('/undangans/{id}/edit', [UndanganController::class, 'edit'])->name('undangans.edit');
Route::put('/undangans/{id}', [UndanganController::class, 'update'])->name('undangans.update');
Route::delete('/undangans/{id}', [UndanganController::class, 'destroy'])->name('undangans.destroy');

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';

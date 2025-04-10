<?php

use App\Http\Controllers\TamuController;
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

// Tamu Routes
Route::get('/tamus', [TamuController::class, 'index'])->name('tamus.index');
Route::get('/tamus/create', [TamuController::class, 'create'])->name('tamus.create');
Route::post('/tamus', [TamuController::class, 'store'])->name('tamus.store');
Route::get('/tamus/{id}/edit', [TamuController::class, 'edit'])->name('tamus.edit');
Route::put('/tamus/{id}', [TamuController::class, 'update'])->name('tamus.update');
Route::delete('/tamus/{id}', [TamuController::class, 'destroy'])->name('tamus.destroy');

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';

<?php

use App\Http\Controllers\WaBlastController;
use Inertia\Inertia;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TamuController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\UndanganController;

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
Route::get('/undangans/contents', [UndanganController::class, 'content'])->name('undangans.contents');
Route::post('/undangans/contents', [UndanganController::class, 'contentStore'])->name('undangans.contents.store');
Route::get('/undangans/preview/{undangan_id?}/{tema?}', [UndanganController::class, 'preview'])->name('undangans.preview');

// Tamu Routes
Route::get('/tamus', [TamuController::class, 'index'])->name('tamus.index');
Route::get('/tamus/create', [TamuController::class, 'create'])->name('tamus.create');
Route::post('/tamus', [TamuController::class, 'store'])->name('tamus.store');
Route::get('/tamus/{id}/edit', [TamuController::class, 'edit'])->name('tamus.edit');
Route::put('/tamus/{id}', [TamuController::class, 'update'])->name('tamus.update');
Route::delete('/tamus/{id}', [TamuController::class, 'destroy'])->name('tamus.destroy');

// Galeri Routes
Route::get('/galeris', [GaleriController::class, 'index'])->name('galeris.index');
Route::get('/galeris/create', [GaleriController::class, 'create'])->name('galeris.create');
Route::post('/galeris', [GaleriController::class, 'store'])->name('galeris.store');
Route::get('/galeris/{id}/edit', [GaleriController::class, 'edit'])->name('galeris.edit');
Route::put('/galeris/{id}', [GaleriController::class, 'update'])->name('galeris.update');
Route::delete('/galeris/{id}', [GaleriController::class, 'destroy'])->name('galeris.destroy');
Route::post('/galeris/store-batch', [GaleriController::class, 'storeBatch'])->name('galeris.store-batch');

// Content Routes
Route::post('/ucapan', [UndanganController::class, 'storeUcapan'])->name('ucapan.store');
Route::get('/ucapan/{undangan_id}', [UndanganController::class, 'ucapan'])->name('ucapan.show');
Route::get('/ucapan', [UndanganController::class, 'adminUcapan'])->name('admin.ucapan.index');
Route::delete('/ucapan/{id}', [UndanganController::class, 'deleteUcapan'])->name('admin.ucapan.destroy');

// Integrasi WAblast
Route::get('/setup', [WaBlastController::class, 'setupDevice'])->name('blast.setup');
Route::get('/connect-device', [WaBlastController::class, 'connectDevice'])->name('blast.connect.device');
Route::get('/generate-qr', [WaBlastController::class, 'generateQR'])->name('blast.generate.qr');
Route::get('/device-check', [WaBlastController::class, 'checkDeviceStatus'])->name('blast.device.check');

// Route::prefix('wablast')->group(function () {
//     //
// });

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';

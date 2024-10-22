<?php

use App\Http\Controllers\ManufactureController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('Home');

// BAHAN BAKU
Route::get('/inventory/material/create', [MaterialController::class, 'create'])->name('Material.create');
Route::post('/inventory/material/', [MaterialController::class, 'store'])->name('Material.store');

// PRODUK
Route::get('/product/create', [ProductController::class, 'create'])->name('Product.create');
Route::post('/product/', [ProductController::class, 'store'])->name('Product.store');
Route::get('/product/', [ProductController::class, 'index'])->name('Product.index');

// BILL OF MATERIAL (BoM)
Route::get('/production/', [ProductionController::class, 'index'])->name('Production.index');
Route::post('/production/', [ProductionController::class, 'store'])->name('Production.store');
Route::get('/production/cetak-pdf/{id}', [ProductionController::class, 'cetakPDF'])->name('Production.cetakPDF');

// MANUFACTURE
Route::get('/manufacture/', [ManufactureController::class, 'index'])->name('Manufacture.index');
Route::post('/manufacture/', [ManufactureController::class, 'store'])->name('Manufacture.store');
Route::get('/get-bom-data/{id}', [ManufactureController::class, 'getBomData']);

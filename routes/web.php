<?php

use App\Http\Controllers\ManufactureController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductionController;
use App\Http\Controllers\VendorController;
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
Route::get('/manufacture/{id}', [ManufactureController::class, 'show']);
Route::post('/manufacture/produce/{id}', [ManufactureController::class, 'produce']);
Route::post('/manufacture/done/{id}', [ManufactureController::class, 'done']);

// PURCHASING
Route::get('/daftar-vendor', [VendorController::class, 'index'])->name('Vendor.index');
Route::post('/vendor', [VendorController::class, 'store'])->name('Vendor.store');
Route::put('/vendor/{id}', [VendorController::class, 'update'])->name('Vendor.update');
Route::delete('/vendor/{id}', [VendorController::class, 'destroy'])->name('Vendor.destroy');
// Route untuk RFQ
// Route untuk menampilkan daftar orders (index)
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

// Route untuk menampilkan form pembuatan order baru (create)
Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');

// Route untuk menyimpan order baru (store)
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');

// Route untuk menampilkan detail order tertentu (show)
Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');

// Route untuk menampilkan form edit order tertentu (edit)
Route::get('/orders/{id}/edit', [OrderController::class, 'edit'])->name('orders.edit');

// Route untuk memperbarui data order tertentu (update)
Route::put('/orders/{id}', [OrderController::class, 'update'])->name('orders.update');

// Route untuk menghapus order tertentu (destroy)
Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');


// Route untuk mengambil data bahan baku berdasarkan vendor
Route::get('/vendor/{id}/bahan-baku', [OrderController::class, 'getBahanBaku'])->name('vendor.bahan_baku');

// Route untuk menghasilkan PDF dari order tertentu
Route::get('/orders/{id}/pdf', [OrderController::class, 'generatePDF'])->name('orders.generatePDF');

// Route untuk menerima order dan mengubah status menjadi pesanan_selesai
Route::post('/orders/{id}/accept', [OrderController::class, 'acceptOrder'])->name('orders.accept');

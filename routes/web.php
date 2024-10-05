<?php

use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('Home');

Route::get('/inventory/material/create', [MaterialController::class, 'create'])->name('Material.create');
Route::post('/inventory/material/', [MaterialController::class, 'store'])->name('Material.store');


Route::get('/inventory/product/create', [ProductController::class, 'create'])->name('Product.create');
Route::get('/inventory/product/', [ProductController::class, 'store'])->name('Product.store');

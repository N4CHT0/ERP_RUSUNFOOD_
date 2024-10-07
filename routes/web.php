<?php

use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('Home');

Route::get('/inventory/material/create', [MaterialController::class, 'create'])->name('Material.create');
Route::post('/inventory/material/', [MaterialController::class, 'store'])->name('Material.store');


Route::get('/product/create', [ProductController::class, 'create'])->name('Product.create');
Route::post('/product/', [ProductController::class, 'store'])->name('Product.store');
Route::get('/product/', [ProductController::class, 'index'])->name('Product.index');

Route::get('/production/', [ProductionController::class, 'index'])->name('Production.index');

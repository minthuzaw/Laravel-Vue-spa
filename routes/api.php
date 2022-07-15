<?php

use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::get('/products', [ProductController::class, 'index'])->name('product.index');
//Route::post('products', [ProductController::class, 'store'])->name('product.store');
//Route::get('/products/{id}', [ProductController::class, 'show'])->name('product.show');
//Route::put('/products/{id}', [ProductController::class, 'update'])->name('product.update');
//Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('product.destroy');

Route::apiResource('products', 'App\Http\Controllers\ProductController');

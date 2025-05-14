<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('customer.pages.index');
});

Route::prefix('auth')
    ->name('auth.')
    ->group(function () {
        Route::get('/login', [AuthController::class, 'showLogin'])->name('showLogin');
        Route::get('/register', [AuthController::class, 'showRegister'])->name('showRegister');
    });

Route::prefix('customer')
    ->name('customer.')
    ->group(function () {
        Route::get('/index', [CustomerController::class, 'showIndex'])->name('showIndex');
        Route::get('/contact', [CustomerController::class, 'showContact'])->name('showContact');
        Route::get('/about', [CustomerController::class, 'showAbout'])->name('showAbout');
        Route::get('/list-products', [CustomerController::class, 'showListProducts'])->name('showListProducts');
        Route::get('/product-detail', [CustomerController::class, 'showProductDetail'])->name('showProductDetail');
        Route::get('/order', [CustomerController::class, 'showOrder'])->name('showOrder');
        Route::get('/cart', [CustomerController::class, 'showCart'])->name('showCart');
        Route::get('/checkout', [CustomerController::class, 'showCheckout'])->name('showCheckout');
    });

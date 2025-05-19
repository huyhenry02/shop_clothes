<?php

use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminCustomerController;
use App\Http\Controllers\AdminEmployeeController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('customer.showIndex');
});

Route::prefix('auth')
    ->name('auth.')
    ->group(function () {
        Route::get('/login', [AuthController::class, 'showLogin'])->name('showLogin');
        Route::get('/register', [AuthController::class, 'showRegister'])->name('showRegister');
        Route::post('/login', [AuthController::class, 'postLogin'])->name('postLogin');
        Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    });

Route::prefix('customer')
    ->name('customer.')
    ->group(function () {
        Route::get('/index', [CustomerController::class, 'showIndex'])->name('showIndex');
        Route::get('/contact', [CustomerController::class, 'showContact'])->name('showContact');
        Route::get('/about', [CustomerController::class, 'showAbout'])->name('showAbout');
        Route::get('/list-products', [CustomerController::class, 'showListProducts'])->name('showListProducts');
        Route::get('/product-detail/{product}', [CustomerController::class, 'showProductDetail'])->name('showProductDetail');
        Route::get('/order', [CustomerController::class, 'showOrder'])->name('showOrder')->middleware('auth');
        Route::get('/cart', [CustomerController::class, 'showCart'])->name('showCart')->middleware('auth');
        Route::get('/checkout', [CustomerController::class, 'showCheckout'])->name('showCheckout')->middleware('auth');

        Route::post('add-to-cart', [CustomerController::class, 'addToCart'])->name('addToCart')->middleware('auth');
        Route::post('update-cart', [CustomerController::class, 'updateCart'])->name('updateCart')->middleware('auth');
        Route::post('delete-cart', [CustomerController::class, 'deleteCart'])->name('deleteCart')->middleware('auth');
        Route::post('checkout', [CustomerController::class, 'postCheckout'])->name('postCheckout')->middleware('auth');
        Route::get('vnpay-return', [CustomerController::class, 'vnpayReturn'])->name('vnpay.return')->middleware('auth');
    });

Route::prefix('admin')
    ->name('admin.')
    ->middleware('auth')
    ->group(function () {
        Route::prefix('employee')
            ->name('employee.')
            ->group(function () {
                Route::get('/index', [AdminEmployeeController::class, 'showIndex'])->name('showIndex');
                Route::get('/create', [AdminEmployeeController::class, 'showCreate'])->name('showCreate');
                Route::get('/update/{employee}', [AdminEmployeeController::class, 'showUpdate'])->name('showUpdate');

                Route::post('/update/{employee}', [AdminEmployeeController::class, 'putEmployee'])->name('putEmployee');
                Route::post('/create', [AdminEmployeeController::class, 'postEmployee'])->name('postEmployee');
                Route::get('/delete/{employee}', [AdminEmployeeController::class, 'delete'])->name('delete');
            });
        Route::prefix('customer')
            ->name('customer.')
            ->group(function () {
                Route::get('/index', [AdminCustomerController::class, 'showIndex'])->name('showIndex');
                Route::get('/create', [AdminCustomerController::class, 'showCreate'])->name('showCreate');
                Route::get('/update/{customer}', [AdminCustomerController::class, 'showUpdate'])->name('showUpdate');

                Route::post('/update/{customer}', [AdminCustomerController::class, 'putCustomer'])->name('putCustomer');
                Route::post('/create', [AdminCustomerController::class, 'postCustomer'])->name('postCustomer');
                Route::get('/delete/{customer}', [AdminCustomerController::class, 'delete'])->name('delete');
            });
        Route::prefix('category')
            ->name('category.')
            ->group(function () {
                Route::get('/index', [AdminCategoryController::class, 'showIndex'])->name('showIndex');
                Route::get('/create', [AdminCategoryController::class, 'showCreate'])->name('showCreate');
                Route::get('/update/{category}', [AdminCategoryController::class, 'showUpdate'])->name('showUpdate');

                Route::post('/create', [AdminCategoryController::class, 'postCategory'])->name('postCategory');
                Route::post('/update/{category}', [AdminCategoryController::class, 'putCategory'])->name('putCategory');
                Route::get('/delete/{category}', [AdminCategoryController::class, 'delete'])->name('delete');
            });
        Route::prefix('product')
            ->name('product.')
            ->group(function () {
                Route::get('/index', [AdminProductController::class, 'showIndex'])->name('showIndex');
                Route::get('/create', [AdminProductController::class, 'showCreate'])->name('showCreate');
                Route::get('/update/{product}', [AdminProductController::class, 'showUpdate'])->name('showUpdate');

                Route::post('/create', [AdminProductController::class, 'postProduct'])->name('postProduct');
                Route::post('/update/{product}', [AdminProductController::class, 'putProduct'])->name('putProduct');
                Route::get('/delete/{product}', [AdminProductController::class, 'delete'])->name('delete');
            });
    });

<?php

use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminCustomerController;
use App\Http\Controllers\AdminEmployeeController;
use App\Http\Controllers\AdminProductController;
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

Route::prefix('admin')
    ->name('admin.')
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
                Route::get('/update', [AdminProductController::class, 'showUpdate'])->name('showUpdate');
            });
    });

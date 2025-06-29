<?php

use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminCustomerController;
use App\Http\Controllers\AdminEmployeeController;
use App\Http\Controllers\AdminInvoiceController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminReportController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

// nơi định nghĩa các đường dẫn url.
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
//         định nghĩa cho 1 đường dẫn url.
        // customer/index
        // CustomerController: tên controller
        // showIndex: tên hàm trong controller
        // name: tên route, dùng để gọi lại trong view hoặc controller
        Route::get('/index', [CustomerController::class, 'showIndex'])->name('showIndex');
        Route::get('/contact', [CustomerController::class, 'showContact'])->name('showContact');
        Route::get('/about', [CustomerController::class, 'showAbout'])->name('showAbout');
        Route::get('/list-products', [CustomerController::class, 'showListProducts'])->name('showListProducts');
        Route::get('/product-detail/{product}', [CustomerController::class, 'showProductDetail'])->name('showProductDetail');
        Route::get('/order', [CustomerController::class, 'showOrder'])->name('showOrder')->middleware('auth');
        Route::get('/cart', [CustomerController::class, 'showCart'])->name('showCart')->middleware('auth');
        Route::get('/checkout', [CustomerController::class, 'showCheckout'])->name('showCheckout')->middleware('auth');
        Route::get('/filter-products', [CustomerController::class, 'filterProducts'])->name('filterProducts');


        Route::post('add-to-cart', [CustomerController::class, 'addToCart'])->name('addToCart')->middleware('auth');
        Route::post('update-cart', [CustomerController::class, 'updateCart'])->name('updateCart')->middleware('auth');
        Route::post('delete-cart', [CustomerController::class, 'deleteCart'])->name('deleteCart')->middleware('auth');
        Route::post('checkout', [CustomerController::class, 'postCheckout'])->name('postCheckout')->middleware('auth');
        Route::get('vnpay-return', [CustomerController::class, 'vnpayReturn'])->name('vnpay.return')->middleware('auth');
    });

Route::prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::prefix('employee')
            ->name('employee.')
            ->middleware('auth')
            ->group(function () {
                Route::get('/index', [AdminEmployeeController::class, 'showIndex'])->name('showIndex');
                Route::get('/create', [AdminEmployeeController::class, 'showCreate'])->name('showCreate');
                Route::get('/update/{employee}', [AdminEmployeeController::class, 'showUpdate'])->name('showUpdate');
                Route::get('/filter-employees', [AdminEmployeeController::class, 'filter'])->name('filter');

                Route::post('/update/{employee}', [AdminEmployeeController::class, 'putEmployee'])->name('putEmployee');
                Route::post('/create', [AdminEmployeeController::class, 'postEmployee'])->name('postEmployee');
                // route dùng để xóa nhân viên
                Route::get('/delete/{employee}', [AdminEmployeeController::class, 'delete'])->name('delete');
            });

        Route::prefix('customer')
            ->name('customer.')
            ->group(function () {
                Route::get('/index', [AdminCustomerController::class, 'showIndex'])->name('showIndex')->middleware('auth');
                Route::get('/create', [AdminCustomerController::class, 'showCreate'])->name('showCreate')->middleware('auth');
                Route::get('/update/{customer}', [AdminCustomerController::class, 'showUpdate'])->name('showUpdate')->middleware('auth');
                Route::get('/filter-customers', [AdminCustomerController::class, 'filter'])->name('filter')->middleware('auth');

                Route::post('/update/{customer}', [AdminCustomerController::class, 'putCustomer'])->name('putCustomer')->middleware('auth');
                Route::post('/create', [AdminCustomerController::class, 'postCustomer'])->name('postCustomer');
                Route::get('/delete/{customer}', [AdminCustomerController::class, 'delete'])->name('delete')->middleware('auth');
            });

        Route::prefix('category')
            ->name('category.')
            ->middleware('auth')
            ->group(function () {
                Route::get('/index', [AdminCategoryController::class, 'showIndex'])->name('showIndex');
                Route::get('/create', [AdminCategoryController::class, 'showCreate'])->name('showCreate');
                Route::get('/update/{category}', [AdminCategoryController::class, 'showUpdate'])->name('showUpdate');
                Route::get('/filter-categories', [AdminCategoryController::class, 'filter'])->name('filter');

                Route::post('/create', [AdminCategoryController::class, 'postCategory'])->name('postCategory');
                Route::post('/update/{category}', [AdminCategoryController::class, 'putCategory'])->name('putCategory');
                Route::get('/delete/{category}', [AdminCategoryController::class, 'delete'])->name('delete');
            });

        Route::prefix('product')
            ->name('product.')
            ->middleware('auth')
            ->group(function () {
                Route::get('/index', [AdminProductController::class, 'showIndex'])->name('showIndex');
                Route::get('/create', [AdminProductController::class, 'showCreate'])->name('showCreate');
                Route::get('/update/{product}', [AdminProductController::class, 'showUpdate'])->name('showUpdate');
                Route::get('/filter-products', [AdminProductController::class, 'filter'])->name('filter');

                Route::post('/create', [AdminProductController::class, 'postProduct'])->name('postProduct');
                Route::post('/update/{product}', [AdminProductController::class, 'putProduct'])->name('putProduct');
                Route::get('/delete/{product}', [AdminProductController::class, 'delete'])->name('delete');
            });

        Route::prefix('order')
            ->name('order.')
            ->middleware('auth')
            ->group(function () {
                Route::get('/index', [AdminOrderController::class, 'showIndex'])->name('showIndex');
                Route::get('/update/{order}', [AdminOrderController::class, 'showUpdate'])->name('showUpdate');
                Route::get('/filter-orders', [AdminOrderController::class, 'filter'])->name('filter');

                Route::post('/update/{order}', [AdminOrderController::class, 'putOrder'])->name('putOrder');
            });


        Route::prefix('invoice')
            ->name('invoice.')
            ->middleware('auth')
            ->group(function () {
                Route::get('/index', [AdminInvoiceController::class, 'showIndex'])->name('showIndex');
                Route::get('/create', [AdminInvoiceController::class, 'showCreate'])->name('showCreate');
                Route::get('/get-product-by-code/{code}', [AdminInvoiceController::class, 'getProductByCode'])->name('getProductByCode');
                Route::get('/update/{invoice}', [AdminInvoiceController::class, 'showUpdate'])->name('showUpdate');
                Route::get('/filter-invoices', [AdminInvoiceController::class, 'filter'])->name('filter');

                Route::post('/create', [AdminInvoiceController::class, 'postInvoice'])->name('postInvoice');
//                xử lý logic khi thanh toán thành công hoặc thất bại
                Route::get('vnpay-return', [AdminInvoiceController::class, 'vnpayReturn'])->name('vnpay.return');
                Route::post('/update/{invoice}', [AdminInvoiceController::class, 'putInvoice'])->name('putInvoice');
                Route::get('/delete/{invoice}', [AdminInvoiceController::class, 'delete'])->name('delete');
                Route::get('/export-pdf/{invoice}', [AdminInvoiceController::class, 'exportInvoicePdf'])->name('exportInvoicePdf');

            });

        Route::prefix('report')
            ->name('report.')
            ->middleware('auth')
            ->group(function () {
                Route::get('/order', [AdminReportController::class, 'showOrder'])->name('showOrder');
                Route::get('/revenue', [AdminReportController::class, 'showRevenue'])->name('showRevenue');
                Route::get('/best-selling', [AdminReportController::class, 'showBestSelling'])->name('showBestSelling');

                Route::get('/getOrderData', [AdminReportController::class, 'getOrderData'])->name('getOrderData');
                Route::get('/getRevenueData', [AdminReportController::class, 'getRevenueData'])->name('getRevenueData');
                Route::get('/getBestSellingData', [AdminReportController::class, 'getBestSellingData'])->name('getBestSellingData');
                Route::get('/export-pdf-best-selling', [AdminReportController::class, 'exportPdfBestSelling'])->name('exportPdfBestSelling');
                Route::get('/export-pdf-order', [AdminReportController::class, 'exportPdfOrder'])->name('exportPdfOrder');
                Route::get('/export-pdf-revenue', [AdminReportController::class, 'exportPdfRevenue'])->name('exportPdfRevenue');
            });
    });

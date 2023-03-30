<?php

use App\Http\Controllers\Api\AddToCartController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Auth\ApiAuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['cors', 'json.response']], function () {
    Route::post('/login', [ApiAuthController::class, 'login'])->name('login.api');
    Route::post('/register', [ApiAuthController::class, 'register'])->name('register.api');
});

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [ApiAuthController::class, 'logout'])->name('logout.api');
    Route::get('/all-customer', [CustomerController::class, 'index'])->middleware('api.admin')->name('customerList.api');

    Route::resource('/product', ProductController::class)->middleware('api.admin');

    Route::resource('/order', OrderController::class)->middleware('api.customer');
    Route::get('/all-orders', [OrderController::class, 'getAllOrders'])->name('allOrders.api');

    Route::resource('/add-to-cart', AddToCartController::class)->middleware('api.customer');
});
Route::get('/all-products', [ProductController::class, 'getAllProducts'])->name('allProduct.api');
Route::get('/search-product', [ProductController::class, 'searchProduct'])->name('search.product');

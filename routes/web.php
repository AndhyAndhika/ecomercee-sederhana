<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MarketPlaceController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/* disable feature register, reset, verify */

Auth::routes([
    'reset' => false,
    'verify' => false,
]);

Route::name('MarketPlace.')->group(function () {
    Route::get('/', [MarketPlaceController::class, 'index'])->name('index');
    Route::get('/my-cart', [MarketPlaceController::class, 'myCart'])->name('myCart');
    Route::post('/cart/add-to-cart', [MarketPlaceController::class, 'addToCart'])->name('addToCart');
    Route::post('/cart/remove-from-cart', [MarketPlaceController::class, 'removeFromCart'])->name('removeFromCart');
    Route::post('/cart/checkout', [MarketPlaceController::class, 'checkout'])->name('checkout');
    Route::get('/product/{slug}', [MarketPlaceController::class, 'detailProduct'])->name('detailProduct');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');

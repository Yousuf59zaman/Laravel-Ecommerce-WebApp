<?php

use Illuminate\Support\Facades\Route;
//import RegisterController

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

Route::get('register', [UserController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [UserController::class, 'register']);
Route::get('login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('login', [UserController::class, 'login']);
Route::get('/', function () {
    return view('home');
});

Route::middleware(['auth'])->group(function () {
    Route::get('profile', [UserController::class, 'showProfile'])->name('profile');
    Route::post('profile', [UserController::class, 'updateProfile']);
});

Route::get('/', [ProductController::class, 'index']);


Route::get('cart', [CartController::class, 'index'])->name('cart.index');
Route::post('cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::post('cart/update/{product}', [CartController::class, 'update'])->name('cart.update');
Route::post('cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
// Display the checkout page
Route::get('checkout', [CartController::class, 'checkout'])->name('checkout');

// Post to actually process the checkout
Route::post('process-checkout', [OrderController::class, 'processCheckout'])->name('process-checkout');
Route::get('/order-placed', function () {
    return view('cart.orderplaced');
})->name('order.placed');
Route::get('orderhistory', [OrderController::class, 'orderhistory'])->name('orderhistory');
Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');

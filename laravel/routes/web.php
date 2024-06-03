<?php

use Illuminate\Support\Facades\Route;
//import RegisterController

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;
Route::get('register', [UserController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [UserController::class, 'register']);
Route::get('login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('login', [UserController::class, 'login']);
Route::get('/admin/users', [UserController::class, 'index'])->name('users.index');
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');


Route::middleware(['auth'])->group(function () {
    Route::get('profile', [UserController::class, 'showProfile'])->name('profile');
    Route::post('profile', [UserController::class, 'updateProfile']);
});

Route::get('/', [ProductController::class, 'index']);
// Route to show detailed product view
Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/admin/products', [ProductController::class, 'adminIndex'])->name('products.index');
// Route to display the add product form
Route::get('/admin/add-product', [ProductController::class, 'create'])->name('products.create');
// Route to store the product
Route::post('/admin/store-product', [ProductController::class, 'store'])->name('products.store');
// Route to display the edit form for a product
Route::get('/admin/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
// Route to handle the update post request
Route::post('/admin/products/{product}', [ProductController::class, 'update'])->name('products.update');
// Route to delete a product
Route::delete('/admin/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');



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
Route::get('ordersAll', [OrderController::class, 'indexAll'])->name('orders.indexAll');
Route::get('orders/{order}', [OrderController::class, 'showDetails'])->name('orders.showDetails');
Route::post('/admin/orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

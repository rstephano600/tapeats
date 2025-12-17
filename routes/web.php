<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Front\HomeController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\supplier\BusinessController;
use App\Http\Controllers\supplier\FoodController;
use App\Http\Controllers\menu\MenuController;


use App\Http\Controllers\menu\MenuController2;


// Public routes
Route::get('/', [MenuController2::class, 'index'])->name('menu.index');
Route::get('/menu', [MenuController2::class, 'index'])->name('menu');
Route::get('/search', [MenuController2::class, 'search'])->name('menu.search');
Route::get('/category/{category}', [MenuController2::class, 'filterByCategory'])->name('menu.category');
Route::get('/supplier/{id}/foods', [MenuController2::class, 'foodsBySupplier'])->name('menu.supplier');

// Protected routes (require authentication)
Route::middleware(['auth'])->group(function () {
    // Order routes
    Route::post('/orders', [MenuController2::class, 'createOrder'])->name('orders.create');
    Route::get('/orders/{id}', [MenuController2::class, 'showOrder'])->name('orders.show');
    Route::get('/my-orders', [MenuController2::class, 'myOrders'])->name('orders.index');
});



Route::get('/supplier/{supplier}/menu', [FoodController::class, 'supplierFoods'])
    ->name('supplier.menu');


// Authentication
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Registration
Route::get('register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Dashboards
Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', fn() => view('dashboard.admin'))->name('admin.dashboard');
    Route::get('/supplier/dashboard', fn() => view('dashboard.supplier'))->name('supplier.dashboard');
    Route::get('/customer/dashboard', fn() => view('dashboard.customer'))->name('customer.dashboard');
    Route::get('/deliver/dashboard', fn() => view('dashboard.deliver'))->name('deliver.dashboard');
});


// Supplier Business Routes
Route::middleware(['auth'])->group(function () {

    Route::get('/business', [BusinessController::class, 'index'])->name('business.index');
    Route::get('/business/create', [BusinessController::class, 'create'])->name('business.create');
    Route::post('/business/store', [BusinessController::class, 'store'])->name('business.store');
    Route::get('/business/{id}/edit', [BusinessController::class, 'edit'])->name('business.edit');
    Route::post('/business/{id}/update', [BusinessController::class, 'update'])->name('business.update');
    Route::delete('/business/{id}', [BusinessController::class, 'destroy'])->name('business.delete');

});

// Admin: List businesses waiting for approval
Route::get('/admin/suppliers/pending', [BusinessController::class, 'pending'])
    ->name('admin.suppliers.pending')
    ->middleware('auth');

// Admin: Verify or Reject
Route::post('/admin/suppliers/verify/{id}', [BusinessController::class, 'verify'])
    ->name('admin.suppliers.verify')
    ->middleware('auth');

    Route::get('supplier/{id}/foods', [MenuController2::class, 'foodsBySupplier'])
    ->name('menu.supplier');

Route::prefix('supplier')->middleware(['auth'])->group(function () {

    Route::get('/foods', [FoodController::class, 'index'])->name('supplier.foods.index');
    Route::get('/foods/create', [FoodController::class, 'create'])->name('supplier.foods.create');
    Route::post('/foods/store', [FoodController::class, 'store'])->name('supplier.foods.store');

    Route::get('/foods/{id}/edit', [FoodController::class, 'edit'])->name('supplier.foods.edit');
    Route::post('/foods/{id}/update', [FoodController::class, 'update'])->name('supplier.foods.update');

    Route::delete('/foods/{id}', [FoodController::class, 'destroy'])->name('supplier.foods.destroy');

});


Route::prefix('Menu')->middleware(['auth'])->group(function () {

    Route::get('/foods', [MenuController::class, 'index'])->name('menu.foods.index');
    Route::get('/foods/create', [MenuController::class, 'create'])->name('menu.foods.create');
    Route::post('/foods/store', [MenuController::class, 'store'])->name('menu.foods.store');
 // Food details (view from the card)
    Route::get('/foods/{id}', [MenuController::class, 'show'])->name('menu.foods.show');
    Route::get('/foods/{id}/edit', [MenuController::class, 'edit'])->name('menu.foods.edit');
    Route::post('/foods/{id}/update', [MenuController::class, 'update'])->name('menu.foods.update');

    Route::delete('/foods/{id}', [MenuController::class, 'destroy'])->name('menu.foods.destroy');

});

use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerOrderController;

Route::middleware(['auth'])->group(function () {

    // Cart
    Route::post('/cart/add/{foodId}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');
    Route::post('/cart/update/{foodId}', [CartController::class, 'updateQty'])->name('cart.update');
    Route::delete('/cart/remove/{foodId}', [CartController::class, 'removeItem'])->name('cart.remove');

    // Checkout / Orders
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/place-order', [OrderController::class, 'placeOrder'])->name('order.place');

    // Customer orders history
    Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('customer.orders');
    Route::get('/my-orders/{id}', [OrderController::class, 'viewOrder'])->name('customer.orders.view');

});

use App\Http\Controllers\OrderController2;

// This should be protected by middleware (e.g., auth)
Route::post('/place-order', [OrderController2::class, 'store'])
    ->middleware('auth') // Crucial for using Auth::id()
    ->name('orders.store');

// Example order view route (for redirection)
Route::get('/orders/{order}', [OrderController2::class, 'show'])
    ->middleware('auth')
    ->name('orders.show');


// Supplier Orders
Route::prefix('supplier')->middleware('auth')->group(function () {

    Route::get('/orders', [\App\Http\Controllers\Supplier\SupplierOrderController::class, 'index'])
        ->name('supplier.orders');

    Route::get('/orders/{id}', [\App\Http\Controllers\Supplier\SupplierOrderController::class, 'show'])
        ->name('supplier.orders.show');

    Route::post('/orders/{id}/status', [\App\Http\Controllers\Supplier\SupplierOrderController::class, 'updateStatus'])
        ->name('supplier.orders.status');
});


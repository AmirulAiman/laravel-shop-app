<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

use App\Models\Product;

Route::get('/', function () {
    $products = Product::with('category')->where('is_active', true)->latest()->get();
    return view('welcome', compact('products'));
})->name('home');


Route::middleware('auth')->group(function () {
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::patch('/dashboard/{order}', [DashboardController::class, 'update'])->name('admin.dashboard.update');
    });
    Route::get('products/import', [ProductController::class, 'import'])->name('products.import');
    Route::resource('products', ProductController::class);
    Route::group(['prefix' => 'carts'], function () {
        Route::get('/', [CartController::class, 'index'])->name('carts.index');
        Route::post('/', [CartController::class, 'store'])->name('carts.store');
        Route::patch('/{item}', [CartController::class, 'update'])->name('carts.update');
        Route::delete('/{item}', [CartController::class, 'destroy'])->name('carts.destroy');
    });
    Route::group(['prefix' => 'checkout'], function() {
        Route::get('/review',[CheckoutController::class, 'review'])->name('checkout.review');
        Route::post('/store',[CheckoutController::class, 'store'])->name('checkout.store');
    });
    Route::group(['prefix' => 'order'], function() {
        Route::get('/update-status',[OrderController::class, 'updateStatus'])->name('order.update-status');
    });
    Route::resource('users', UserController::class);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

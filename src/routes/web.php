<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\OrderAdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WebhookController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'index'])->name('home');

Route::resource('products', ProductController::class);
Route::resource('coupons', CouponController::class)->except(['show']);
Route::get('cart', [CartController::class, 'index'])->name('cart.index');
Route::post('cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('checkout/thanks/{id}', [CheckoutController::class, 'thanks'])->name('checkout.thanks');
Route::get('orders', [OrderAdminController::class, 'index'])->name('orders.index');
Route::put('orders/{id}', [OrderAdminController::class, 'update'])->name('orders.update');
Route::delete('orders/{id}', [OrderAdminController::class, 'destroy'])->name('orders.destroy');
Route::patch('orders/{order}/status', [OrderAdminController::class, 'updateStatus'])
    ->name('orders.updateStatus');

Route::post('/webhook/order-status', [WebhookController::class, 'handle']);

<?php

use Apydevs\Orders\Http\Controllers\OrdersController;
use Illuminate\Support\Facades\Route;
Route::middleware([
    'web',
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
Route::get('/orders', [OrdersController::class, 'index'])->name('orders.index');
// Route::get('/orders/create', [OrdersController::class, 'create'])->name('orders.create');
// Route::post('/orders', [OrdersController::class, 'store'])->name('orders.store');
// Route::get('/orders/{order}', [OrdersController::class, 'show'])->name('orders.show');
// Route::get('/orders/{order}/edit', [OrdersController::class, 'edit'])->name('orders.edit');
// Route::put('/orders/{order}', [OrdersController::class, 'update'])->name('orders.update');
// Route::delete('/orders/{order}', [OrdersController::class, 'destroy'])->name('orders.destroy');
});

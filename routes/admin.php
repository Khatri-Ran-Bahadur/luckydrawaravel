<?php

use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CashDrawController;
use App\Http\Controllers\Admin\ProductDrawController;



Route::group(['middleware' => ['admin'], 'as' => 'admin.', 'prefix' => 'admin'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resources([
        'cashdraws' => CashDrawController::class,
        'productdraws' => ProductDrawController::class,

    ]);
});

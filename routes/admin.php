<?php

use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CashDrawController;
use App\Http\Controllers\Admin\ProductDrawController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SpecialUserController;
use App\Http\Controllers\Admin\AdminController;
use App\Models\User;

Route::group(['middleware' => ['admin'], 'as' => 'admin.', 'prefix' => 'admin'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('admins/reset-password', [AdminController::class, 'resetPassword'])->name('admins.reset-password');

    Route::controller(UserController::class)->group(function () {
        Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
            Route::get('/', 'index')->name('index');
            Route::delete('{id}', 'destroy')->name('destroy');
            Route::get('toggle-special-user/{id}', 'toggleSpecialUser')->name('toggleSpecialUser');
            Route::post('change-password', 'resetPassword')->name('changePassword');
            // special users
            Route::get('special-users', 'specialUsers')->name('special-users');
            Route::get('special-users-request', 'specialUsersRequest')->name('special-users-request');

            Route::get('{id}', 'show')->name('show');
        });
    });



    Route::resources([
        'cashdraws' => CashDrawController::class,
        'productdraws' => ProductDrawController::class,
        'admins' => AdminController::class,
    ]);
});

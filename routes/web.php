<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\WalletController;
use App\Http\Controllers\User\SpecialUserController;

Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/cash-draws', 'cashDraws')->name('cash-draws');
    Route::get('/cash-draws/{id}', 'cashDrawDetail')->name('cash-draw-detail');
    Route::post("/cash-draws/{id}/enter", "cashDrawEnter")->name('cash-draw-enter');
    Route::get('/product-draws', 'productDraws')->name('product-draws');
    Route::post("/product-draws/{id}/enter", "productDrawEnter")->name('product-draw-enter');
    Route::get('/winners', 'winners')->name('winners');
    Route::get('/contact-us', 'contactUs')->name('contact-us');
    Route::get('/about-us', 'aboutUs')->name('about-us');
    Route::get('/privacy-policy', 'privacyPolicy')->name('privacy-policy');
    Route::get('/terms-and-conditions', 'termsAndConditions')->name('terms-and-conditions');
    Route::get('/faqs', 'faq')->name('faq');
});


Auth::routes();


Route::group(['middleware' => ['user'], 'as' => 'user.', 'prefix' => 'user'], function () {
    Route::controller(UserController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard');
        Route::get('/profile', 'profile')->name('profile');
        Route::get('/winnings', 'winnings')->name('winnings');
        Route::post('/update', 'updateProfile')->name('update-profile');
        Route::post('/change-password', 'changePassword')->name('change-password');
    });

    Route::controller(WalletController::class)->group(function () {
        Route::group(['prefix' => 'wallet', 'as' => 'wallet.'], function () {
            Route::get('/', 'index')->name('index');
            Route::get('/deposit', 'deposit')->name('deposit');
            Route::post('/deposit', 'processDeposit')->name('deposit.process');
            Route::get('/withdraw', 'withdraw')->name('withdrawal');
            Route::post('/withdraw', 'processWithdraw')->name('withdrawal.process');

            Route::get('/sendmoney', 'sendmoney')->name('sendmoney');
            Route::post('/sendmoney', 'processSendmoney')->name('sendmoney.process');

            Route::get('/user-requests', 'userRequests')->name('user-requests');
            Route::post('/user-requests', 'processUserRequests')->name('user-requests.process');
        });

        // Special User Request Routes
        Route::controller(SpecialUserController::class)->group(function () {
            Route::get('/request-special-user', 'create')->name('request-special-user.create');
            Route::post('/request-special-user', 'store')->name('request-special-user.store');
        });
    });
});


require __DIR__ . '/admin.php';

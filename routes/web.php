<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\User\UserController;


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
});


require __DIR__ . '/admin.php';

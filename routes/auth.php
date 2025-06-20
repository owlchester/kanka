<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Illuminate\Support\Facades\Auth::routes(['register' => config('auth.register_enabled')]);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/login-as-user/{user}', [LoginController::class, 'loginAsUser'])->name('login-as-user');
Route::get('/login-as', [LoginController::class, 'loginAs'])->name('login-as');

// OAuth Routes
Route::get('auth/{provider}', [AuthController::class, 'redirectToProvider'])->name('auth.provider');

include 'oauth.php';
/*
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');

Route::post('logout', 'Auth\LoginController@logout')->name('logout');



// Registration Routes...
if (config('auth.register_enabled')) {
    Route::get('register', 'Auth\LoginController@showRegistrationForm')->name('register');
    Route::post('register', 'Auth\LoginController@register');
}

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');


// Password Confirmation Routes...
Route::get('password/confirm', 'Auth\ConfirmPasswordController@showConfirmForm')->name('password.confirm');
Route::post('password/confirm', 'Auth\ConfirmPasswordController@confirm');

// Email Verification Routes...
Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify');
Route::post('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');
*/

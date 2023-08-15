<?php

use App\Http\Controllers\User\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('users/{user}', [ProfileController::class, 'show'])->name('users.profile');

//Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

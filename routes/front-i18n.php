<?php

use App\Http\Controllers\User\ProfileController;
use Illuminate\Support\Facades\Route;

//
//Route::group(['prefix' => 'helper'], function () {
//    Route::get('/api-filters', [HelperController::class, 'apiFilters'])
//        ->name('helpers.api-filters');
//});

Route::get('users/{user}', [ProfileController::class, 'show'])->name('users.profile');

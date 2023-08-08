<?php

use Illuminate\Support\Facades\Route;

// Documentation catch all
Route::get('/documentation', 'FrontController@documentation')->name('documentation');
Route::get('/docs', 'FrontController@documentation');
Route::get('/api', 'FrontController@api');
Route::get('/docs/1.0/{sub}', 'FrontController@api');

Route::get('/go/{social}', [\App\Http\Controllers\Front\GoController::class, 'index'])->name('go.social');

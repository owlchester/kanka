<?php

use Illuminate\Support\Facades\Route;

// API docs
Route::group([
    'prefix'     => config('larecipe.docs.route'),
    'domain'     => config('larecipe.domain', null),
    'as'         => 'larecipe.',
    'middleware' => 'web'
], function () {
    Route::get('/', '\BinaryTorch\LaRecipe\Http\Controllers\DocumentationController@index')->name('index');
    Route::get('/{version}/{page?}', '\BinaryTorch\LaRecipe\Http\Controllers\DocumentationController@show')->where('page', '(.*)')->name('show');
});

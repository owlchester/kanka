<?php

use Illuminate\Support\Facades\Route;
use Vsch\TranslationManager\Translator;

// API docs
Route::group([
    'prefix' => config('larecipe.docs.route'),
    'domain' => config('larecipe.domain', null),
    'as' => 'larecipe.',
    'middleware' => 'web',
], function () {
    Route::get('/', '\BinaryTorch\LaRecipe\Http\Controllers\DocumentationController@index')->name('index');
    Route::get('/{version}/{page?}', '\BinaryTorch\LaRecipe\Http\Controllers\DocumentationController@show')->where('page', '(.*)')->name('show');
});

// 3rd party
Route::group(['middleware' => ['auth', 'translator'], 'prefix' => 'translations'], function () {
    Translator::routes();
});

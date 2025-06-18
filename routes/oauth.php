<?php

Route::prefix('oauth')->group(function () {
    Route::get('/tokens', [
        'uses' => '\Laravel\Passport\Http\Controllers\AuthorizedAccessTokenController@forUser',
        'as' => 'tokens.index',
    ]);

    Route::delete('/tokens/{token_id}', [
        'uses' => '\Laravel\Passport\Http\Controllers\AuthorizedAccessTokenController@destroy',
        'as' => 'tokens.destroy',
    ]);

    Route::get('/clients', [
        'uses' => '\Laravel\Passport\Http\Controllers\ClientController@forUser',
        'as' => 'clients.index',
    ]);

    Route::post('/clients', [
        'uses' => '\App\Http\Controllers\Passport\ClientController@store',
        'as' => 'clients.store',
    ]);

    Route::put('/clients/{client_id}', [
        'uses' => '\Laravel\Passport\Http\Controllers\ClientController@update',
        'as' => 'clients.update',
    ]);

    Route::delete('/clients/{client_id}', [
        'uses' => '\Laravel\Passport\Http\Controllers\ClientController@destroy',
        'as' => 'clients.destroy',
    ]);

    Route::get('/scopes', [
        'uses' => '\Laravel\Passport\Http\Controllers\ScopeController@all',
        'as' => 'scopes.index',
    ]);

    Route::get('/personal-access-tokens', [
        'uses' => '\Laravel\Passport\Http\Controllers\PersonalAccessTokenController@forUser',
        'as' => 'personal.tokens.index',
    ]);

    Route::post('/personal-access-tokens', [
        'uses' => '\Laravel\Passport\Http\Controllers\PersonalAccessTokenController@store',
        'as' => 'personal.tokens.store',
    ]);

    Route::delete('/personal-access-tokens/{token_id}', [
        'uses' => '\Laravel\Passport\Http\Controllers\PersonalAccessTokenController@destroy',
        'as' => 'personal.tokens.destroy',
    ]);
});

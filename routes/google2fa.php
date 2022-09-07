<?php

/*
--------------------------------------------------------------------------
Google2FA
--------------------------------------------------------------------------
*/

// Display 2FA form if User has generated Google2FA
Route::get('/2fa', 'PasswordSecurityController@show2faForm');

Route::post('/cancel-2fa', 'PasswordSecurityController@cancel2FA')->name('cancel-2fa');


// Generate a new Google2FA code if a User does not already have one
Route::post('/generate2faSecret', [
    'uses' => 'PasswordSecurityController@generate2faSecretCode',
    'as'   => 'generate2faSecretCode'
]);

// Enable 2FA for User
Route::post('/enable2fa', [
    'uses' => 'PasswordSecurityController@enable2fa',
    'as'   => 'enable2fa'
]);

// Disable 2FA for User
Route::post('/disable2fa', [
    'uses' => 'PasswordSecurityController@disable2fa',
    'as'   => 'disable2fa'
]);

// Verify 2FA if User has it enabled
Route::post('/verify2fa', function() {
    return redirect()->route('home');
})->name('verify2fa')->middleware('2fa');


Route::get('/verify2fa', function() {
    return redirect(URL()->previous());
})->name('verify2fa')->middleware('2fa');

/*
--------------------------------------------------------------------------
Google2FA
--------------------------------------------------------------------------
*/

<?php

use Illuminate\Support\Facades\Route;

Route::get('/referrals', 'ReferralController@index')->name('referrals');

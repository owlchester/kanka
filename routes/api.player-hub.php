<?php

use App\Http\Controllers\Api\v1\PlayerHub\ClaimController;
use App\Http\Controllers\Api\v1\PlayerHub\SetupController;
use Illuminate\Support\Facades\Route;

Route::get('player-hub/setup', [SetupController::class, 'index']);
Route::post('player-hub/{entity}/claim', [ClaimController::class, 'store'])
    ->whereNumber('entity')
    ->name('player-hub.claim');

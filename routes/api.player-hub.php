<?php

use App\Http\Controllers\Api\v1\PlayerHub\ClaimController;
use App\Http\Controllers\Api\v1\PlayerHub\InteractionLogController;
use App\Http\Controllers\Api\v1\PlayerHub\PlayerSessionController;
use App\Http\Controllers\Api\v1\PlayerHub\SetupController;
use Illuminate\Support\Facades\Route;

Route::get('player-hub/setup', [SetupController::class, 'index']);
Route::apiResource('player-hub/player-sessions', PlayerSessionController::class);
Route::apiResource('player-hub/player-sessions.interactions', InteractionLogController::class);
Route::post('player-hub/{entity}/claim', [ClaimController::class, 'store'])
    ->whereNumber('entity')
    ->name('player-hub.claim');

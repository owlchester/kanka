<?php

use App\Http\Controllers\Api\v1\PlayerHub\ClaimController;
use App\Http\Controllers\Api\v1\PlayerHub\EntityController;
use App\Http\Controllers\Api\v1\PlayerHub\InteractionLogController;
use App\Http\Controllers\Api\v1\PlayerHub\PlayerSessionController;
use App\Http\Controllers\Api\v1\PlayerHub\SearchController;
use App\Http\Controllers\Api\v1\PlayerHub\SetupController;
use Illuminate\Support\Facades\Route;

Route::get('player-hub/setup', [SetupController::class, 'index']);
Route::get('player-hub/search', [SearchController::class, 'index'])
    ->name('player-hub.search');
Route::get('player-hub/entities/{entity}', [EntityController::class, 'show'])
    ->whereNumber('entity')
    ->name('player-hub.entities.show');
Route::apiResource('player-hub/player-sessions', PlayerSessionController::class);
Route::apiResource('player-hub/player-sessions.interactions', InteractionLogController::class);
Route::post('player-hub/player-sessions/{player_session}/recover', [PlayerSessionController::class, 'recover'])
    ->whereNumber('player_session')
    ->name('player-hub.player-sessions.recover');
Route::post('player-hub/player-sessions/{player_session}/interactions/{interaction}/recover', [InteractionLogController::class, 'recover'])
    ->whereNumber('player_session')
    ->whereNumber('interaction')
    ->name('player-hub.player-sessions.interactions.recover');
Route::post('player-hub/{entity}/claim', [ClaimController::class, 'store'])
    ->whereNumber('entity')
    ->name('player-hub.claim');

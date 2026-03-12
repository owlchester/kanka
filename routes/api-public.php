<?php

use App\Http\Controllers\Api\Public\CampaignController;
use App\Http\Controllers\Api\Public\HallOfFameController;
use App\Http\Controllers\Api\Public\KbController;
use App\Http\Controllers\Api\Public\ShowcaseController;
use App\Http\Controllers\Api\Public\VoteController;

Route::get('hall-of-fame', [HallOfFameController::class, 'index']);
Route::get('campaigns', [CampaignController::class, 'index']);
Route::get('showcase', [ShowcaseController::class, 'index']);
Route::get('campaigns-setup', [CampaignController::class, 'setup']);
Route::get('votes', [VoteController::class, 'index']);
Route::get('votes/{community_vote}', [VoteController::class, 'show']);
Route::get('kb', [KbController::class, 'index']);

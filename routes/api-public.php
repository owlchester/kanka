<?php

Route::get('hall-of-fame', [App\Http\Controllers\Api\Public\HallOfFameController::class, 'index']);
Route::get('campaigns', [App\Http\Controllers\Api\Public\CampaignController::class, 'index']);
Route::get('showcase', [App\Http\Controllers\Api\Public\ShowcaseController::class, 'index']);
Route::get('campaigns-setup', [App\Http\Controllers\Api\Public\CampaignController::class, 'setup']);
Route::get('votes', [App\Http\Controllers\Api\Public\VoteController::class, 'index']);
Route::get('votes/{community_vote}', [App\Http\Controllers\Api\Public\VoteController::class, 'show']);
Route::get('kb', [App\Http\Controllers\Api\Public\KbController::class, 'index']);

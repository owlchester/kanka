<?php


Route::get('kb', [\App\Http\Controllers\Api\Public\KbController::class, 'index']);
Route::get('votes', [\App\Http\Controllers\Api\Public\VoteController::class, 'index']);
Route::get('votes/{community_vote}', [\App\Http\Controllers\Api\Public\VoteController::class, 'show']);

<?php

use App\Http\Controllers\CampaignController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\StartController;
use App\Http\Controllers\TroubleshootingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/start', [StartController::class, 'index'])->name('start');
Route::post('/create-campaign', [CampaignController::class, 'store'])->name('create-campaign');

// Invitation's campaign comes from the token.
Route::get('/invitation/join/{token}', [InvitationController::class, 'join'])->name('campaigns.join');

Route::get('/troubleshooting/invite', [TroubleshootingController::class, 'invite'])->name('troubleshooting');
Route::post('/troubleshooting/invite', [TroubleshootingController::class, 'saveInvite'])->name('troubleshooting.generate');



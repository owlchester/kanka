<?php

use App\Http\Controllers\Campaign\CreateController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\TroubleshootingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/new-campaign', [CreateController::class, 'index'])->name('start');
Route::post('/new-campaign', [CreateController::class, 'store'])->name('create-campaign');

// Invitation's campaign comes from the token.
Route::get('/invitation/join/{token}', [InvitationController::class, 'join'])->name('campaigns.join');

Route::get('/assistance', [TroubleshootingController::class, 'index'])->name('troubleshooting');
Route::post('/assistance', [TroubleshootingController::class, 'store'])->name('troubleshooting.generate');

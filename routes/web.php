<?php

use App\Http\Controllers\CampaignController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\Layout\NavigationController;
use App\Http\Controllers\StartController;
use App\Http\Controllers\TroubleshootingController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'localizeDatetime']
], function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/start', [StartController::class, 'index'])->name('start');
    Route::post('/create-campaign', [CampaignController::class, 'store'])->name('create-campaign');

    // Invitation's campaign comes from the token.
    Route::get('/invitation/join/{token}', [InvitationController::class, 'join'])->name('campaigns.join');

    Route::get('/troubleshooting/invite', [TroubleshootingController::class, 'invite'])->name('troubleshooting');
    Route::post('/troubleshooting/invite', [TroubleshootingController::class, 'saveInvite'])->name('troubleshooting.generate');


    // Notification
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
    Route::get('/notifications/refresh', [NotificationController::class, 'refresh'])->name('notifications.refresh');
    Route::post('/notifications/read/{id}', [NotificationController::class, 'read'])->name('notifications.read');
    Route::post('/notifications/clear-all', [NotificationController::class, 'clearAll'])->name('notifications.clear-all');

    Route::get('/layout/navigation', [NavigationController::class, 'index'])->name('layout.navigation');
});

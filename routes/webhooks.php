<?php
use App\Http\Controllers\Facebook\DeletionController;

Route::post(
    'stripe/webhook',
    '\App\Http\Controllers\WebhookController@handleWebhook'
)->name('cashier.webhook');



Route::post('/facebook/data-deletion', [DeletionController::class, 'handle']);
Route::get('/facebook/data-deletion/status', [DeletionController::class, 'status']);
Route::get('/facebook/data-deletion/generate', [DeletionController::class, 'generate']);

<?php

Route::post(
    'stripe/webhook',
    '\App\Http\Controllers\WebhookController@handleWebhook'
)->name('cashier.webhook');

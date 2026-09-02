<?php

use Illuminate\Support\Facades\Route;

it('does not expose the legacy PayPal routes', function () {
    expect(Route::has('paypal.process-transaction'))->toBeFalse()
        ->and(Route::has('paypal.transaction-success'))->toBeFalse()
        ->and(Route::has('paypal.cancel-transaction'))->toBeFalse()
        ->and(Route::has('paypal.renew'))->toBeFalse()
        ->and(Route::has('paypal.renew-process'))->toBeFalse()
        ->and(Route::has('paypal.renew-success'))->toBeFalse()
        ->and(Route::has('paypal.renew-cancel'))->toBeFalse();
});

<?php

use App\Mail\Subscription\User\PaypalExpiringMail;
use App\Models\User;

it('does not expose a renew url', function () {
    $user = User::factory()->create();

    $mail = new PaypalExpiringMail($user);

    expect(property_exists($mail, 'renewUrl'))->toBeFalse();
});

it('renders a link to the subscription page', function () {
    $user = User::factory()->create();

    $rendered = (new PaypalExpiringMail($user))->render();

    expect($rendered)->toContain(route('settings.subscription'));
});

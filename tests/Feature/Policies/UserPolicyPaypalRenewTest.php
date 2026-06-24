<?php

use App\Models\User;
use App\Policies\UserPolicy;

it('blocks paypal renewal regardless of subscription state', function () {
    $user = User::factory()->create();

    $policy = new UserPolicy;

    expect($policy->renewPaypalSubscription($user))->toBeFalse();
});

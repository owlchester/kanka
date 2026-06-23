<?php

use App\Models\Tier;
use App\Models\User;

it('redirects to subscription page when setup_intent_client_secret is missing', function () {
    config(['services.stripe.enabled' => true]);

    $user = User::factory()->create();
    $tier = Tier::factory()->create();

    $this->actingAs($user)
        ->get(route('settings.subscription.payment-return', ['tier' => $tier]))
        ->assertRedirect(route('settings.subscription'));
});

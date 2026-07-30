<?php

use App\Models\User;

it('redirects users without a Stripe customer to the payment method page', function () {
    $user = User::factory()->create(['stripe_id' => null]);

    $this->withoutMiddleware();

    $this->actingAs($user)
        ->get(route('billing.portal'))
        ->assertRedirect(route('billing.payment-method'));
});

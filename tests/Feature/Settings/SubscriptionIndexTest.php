<?php

it('defaults subscription pricing to yearly', function () {
    config(['services.stripe.enabled' => true]);
    $this->asUser();

    $this->get(route('settings.subscription'))
        ->assertOk()
        ->assertSee('text-neutral-content transition-all duration-150" data-period="monthly', false)
        ->assertSee('bg-base-100 flex items-center cursor-pointer justify-center gap-1 transition-all duration-150" data-period="yearly', false)
        ->assertSee('gap-4 period-year mx-auto lg:mx-0" id="pricing-overview', false);
});

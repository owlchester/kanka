<?php

use App\Jobs\Users\NewPassword;
use App\Models\User;
use Illuminate\Support\Facades\Bus;

it('asks for the user and template when arguments are omitted', function () {
    $user = User::factory()->create();
    Bus::fake();

    $this->artisan('test:email')
        ->expectsQuestion('User ID', (string) $user->id)
        ->expectsChoice('Email template', 'password', [
            'cancelled',
            'downgrade',
            'elemental',
            'wyvern',
            'owlbear',
            'failed',
            'upcoming',
            'password',
            'first',
            'second',
            'feature',
        ])
        ->assertSuccessful();

    Bus::assertDispatched(NewPassword::class);
});

it('continues to support explicit user and template arguments', function () {
    $user = User::factory()->create();
    Bus::fake();

    $this->artisan('test:email', [
        'user' => $user->id,
        'template' => 'password',
    ])->assertSuccessful();

    Bus::assertDispatched(NewPassword::class);
});

<?php

use App\Mail\Subscription\User\CancelledUserSubscriptionMail;
use App\Mail\Subscription\User\NewElementalSubscriptionMail;
use App\Mail\Subscription\User\NewSubscriberMail;
use App\Mail\Subscription\User\ValidationEmail;
use App\Models\SubscriptionCancellation;
use App\Models\Tier;
use App\Models\User;

it('uses the configured mail sender name for subscription user emails', function () {
    config(['mail.from.name' => 'Configured Sender']);

    $user = User::factory()->make();
    $cancellation = new SubscriptionCancellation;
    $cancellation->setRelation('user', $user);

    expect([
        (new NewElementalSubscriptionMail($user))->envelope()->from->name,
        (new CancelledUserSubscriptionMail($cancellation))->envelope()->from->name,
        (new NewSubscriberMail($user, new Tier))->envelope()->from->name,
    ])->each->toBe('Configured Sender');

    expect((new ValidationEmail($user, 'https://kanka.io/validate'))->build()->from[0]['name'])
        ->toBe('Configured Sender');
});

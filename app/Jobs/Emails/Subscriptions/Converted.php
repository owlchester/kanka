<?php

namespace App\Jobs\Emails\Subscriptions;

use App\Mail\Admin\Subscriptions\ConvertedMail;
use App\Models\TierPrice;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class Converted implements ShouldQueue
{
    use Queueable;

    public int $userId;

    /**
     * Create a new job instance.
     */
    public function __construct(
        User $user,
    ) {
        $this->userId = $user->id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user = User::find($this->userId);
        if (empty($user)) {
            return;
        }

        // Guess the period based on the sub's end date
        $price = $user->subscription('kanka')->stripe_price;
        /** @var ?TierPrice $price */
        $price = TierPrice::where('stripe_id', $price)->first();

        Mail::to('hello@kanka.io')
            ->send(
                new ConvertedMail($user, $price->period)
            );
    }
}

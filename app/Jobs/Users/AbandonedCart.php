<?php

namespace App\Jobs\Users;

use App\Models\Tier;
use App\Models\User;
use App\Services\NewsletterService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class AbandonedCart implements ShouldQueue
{
    use Queueable;

    protected int $user;

    protected string $tier;

    /**
     * Create a new job instance.
     */
    public function __construct(User $user, Tier $tier)
    {
        $this->user = $user->id;
        $this->tier = $tier->name;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        /** @var ?User $user */
        $user = User::find($this->user);
        if (empty($user)) {
            Log::warning('Jobs/Users/AbandonedCart', ['unknown user', 'user' => $this->user]);
            return;
        }
        Log::info('Jobs/Users/AbandonedCart', ['start', 'user' => $this->user]);

        // If the user subbed, we don't do anything
        if (!$user->hasNewsletter() || $user->subscribed('kanka')) {
            return;
        }

        $fields = [
            'abandoned_cart' => now()->format('Y-m-d'),
            'abandoned_package' => $this->tier,
        ];

        /** @var NewsletterService $service */
        $service = app()->make(NewsletterService::class);

        $options = [
            'releases' => true,
            'new' => false
        ];
        //Log::warning('Jobs/Users/AbandonnedCard', ['fields' => $fields]);

        $service->user($user)->fields($fields)->update($options);
    }
}

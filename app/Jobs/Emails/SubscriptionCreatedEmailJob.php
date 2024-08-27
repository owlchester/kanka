<?php

namespace App\Jobs\Emails;

use App\Enums\PricingPeriod;
use App\Mail\Subscription\Admin\NewSubscriptionMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SubscriptionCreatedEmailJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /** @var int user id */
    public $userId;

    /** @var bool if new or changed */
    public $new;

    public PricingPeriod $period;

    /** @var int how many times the job can fail before quitting */
    public $tries = 3;

    /**
     * WelcomeEmailJob constructor.
     * @param bool $new if it's a new sub or a changed sub
     */
    public function __construct(User $user, PricingPeriod $period, bool $new = true)
    {
        $this->userId = $user->id;
        $this->new = $new;
        $this->period = $period;
    }

    /**
     *
     */
    public function handle()
    {
        // User deleted their account already? Sure thing
        $user = User::find($this->userId);
        if (empty($user)) {
            return;
        }
        if ($this->new) {
            // Send an email to the admins
            Mail::to('hello@kanka.io')
                ->send(
                    new NewSubscriptionMail($user, $this->period)
                );
        }
    }
}

<?php

namespace App\Jobs\Emails\Subscriptions;

use App\Mail\Subscription\User\UpcomingYearlyEmail;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class UpcomingYearlyAlert implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var int user id */
    protected $user;

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user->id;
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function handle()
    {
        // User deleted their account already? Sure thing
        /** @var User $user */
        $user = User::find($this->user);
        if (empty($user)) {
            return;
        }

        // Send an email to the user
        Mail::to($user->email)
            ->locale($user->locale)
            ->send(
                new UpcomingYearlyEmail($user)
            );
    }

}

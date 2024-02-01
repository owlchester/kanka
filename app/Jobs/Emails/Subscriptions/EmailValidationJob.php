<?php

namespace App\Jobs\Emails\Subscriptions;

use App\Mail\Subscription\User\ValidationEmail;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class EmailValidationJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected int $user;
    protected string $token;

    /**
     */
    public function __construct(User $user, string $token)
    {
        $this->user = $user->id;
        $this->token = $token;
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function handle()
    {
        // User deleted their account already? Sure thing
        /** @var User|null $user */
        $user = User::find($this->user);
        if (empty($user)) {
            return;
        }
        $url = route('validation.email', ['user' => $user, 'token' => $this->token]);
        // Send an email to the user
        Mail::to($user->email)
            ->locale($user->locale)
            ->send(
                new ValidationEmail($user, $url)
            );
    }
}

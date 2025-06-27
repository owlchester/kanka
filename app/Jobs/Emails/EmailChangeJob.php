<?php

namespace App\Jobs\Emails;

use App\Mail\Subscription\User\EmailChangeMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class EmailChangeJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /** @var int user id */
    protected $user;

    /** @var string email */
    protected $email;

    public function __construct(User $user, string $email)
    {
        $this->user = $user->id;
        $this->email = $email;
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

        // Send an email to the user
        Mail::to($this->email)
            ->locale($user->locale)
            ->send(
                new EmailChangeMail($user)
            );
    }
}

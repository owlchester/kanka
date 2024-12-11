<?php

namespace App\Jobs\Users;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Exception;

class NewPassword implements ShouldQueue
{
    use Queueable;

    protected int $userId;

    /**
     * Create a new job instance.
     */
    public function __construct(User $user)
    {
        $this->userId = $user->id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        /** @var User|null $user */
        $user = User::find($this->userId);
        if (empty($user)) {
            Log::warning('Jobs/Users/NewPassword', ['unknown user', 'user' => $this->userId]);
            return;
        }

        $target = app()->isProduction() ? $user->email : config('mail.from.address');
        try {
            Mail::to($target)
                ->locale($user->locale ?? 'en-US')
                ->send(
                    new \App\Mail\Users\NewPassword($user)
                );
        } catch (\GuzzleHttp\Exception\ServerException $e) {
            // Silence
        } catch (Exception $e) {
            // Something went wrong with mailgun, or the email is invalid. Silence these errors
            // to avoid spamming sentry.
            throw $e;
        }


    }
}

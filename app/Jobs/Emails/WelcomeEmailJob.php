<?php

namespace App\Jobs\Emails;

use App\Mail\WelcomeEmail;
use App\Models\User;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class WelcomeEmailJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * @var int
     */
    public $userId;

    /**
     * @var string
     */
    public $language;

    public $tries = 3;

    /**
     * WelcomeEmailJob constructor.
     */
    public function __construct(User $user, string $language = 'en')
    {
        $this->userId = $user->id;
        $this->language = $language;
    }

    /**
     * Handle the job
     */
    public function handle()
    {
        $user = User::find($this->userId);
        // In a dev environment, it's possible that the queue wasn't running and
        // the user was deleted before we even get to send the welcome email.
        if (empty($user)) {
            return;
        }
        Log::info('WelcomeEmailJob', ['user' => $this->userId]);

        // try {
        Mail::to($user->email)
            ->locale($this->language)
            ->send(
                new WelcomeEmail($user)
            );
        /*} catch (\GuzzleHttp\Exception\ServerException $e) {
            // Silence
        } catch (Exception $e) {
            // Something went wrong with mailgun, or the email is invalid. Silence these errors
            // to avoid spamming sentry.
            throw $e;
        }*/
    }
}

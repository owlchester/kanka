<?php


namespace App\Jobs\Emails;


use App\Mail\WelcomeEmail;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class WelcomeEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var int
     */
    public $userId;

    /**
     * @var string
     */
    public $language;

    /**
     *
     */
    public $tries = 3;

    /**
     * WelcomeEmailJob constructor.
     * @param User $user
     * @param string $language
     */
    public function __construct(User $user, string $language = 'en')
    {
        $this->userId = $user->id;
        $this->language = $language;
    }

    public function handle()
    {
        $user = User::findOrFail($this->userId);
        Mail::to($user->email)
            ->locale($this->language)
            ->send(
                new WelcomeEmail($user)
            );
    }
}

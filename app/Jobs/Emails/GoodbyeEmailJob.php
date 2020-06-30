<?php


namespace App\Jobs\Emails;


use App\Mail\UserDeleted;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class GoodbyeEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string
     */
    public $email;

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
        $this->email = $user->email;
        $this->language = $language;
    }

    public function handle()
    {
        Mail::to('hello@kanka.io')
            ->locale($this->language)
            ->send(
                new UserDeleted($this->userId, $this->email)
            );
    }
}

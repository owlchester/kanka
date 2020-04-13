<?php


namespace App\Jobs\Emails;


use App\Services\NewsletterService;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MailSettingsChangeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var int
     */
    public $userId;

    /** @var int how many times the job can fail before quitting */
    public $tries = 3;

    /**
     * MailSettingsChangeJob constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->userId = $user->id;
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function handle()
    {
        // User deleted their account already? Sure thing
        /** @var User $user */
        $user = User::find($this->userId);
        if (empty($user)) {
            return;
        }

        /** @var NewsletterService $newsletter */
        $newsletter = app()->make(NewsletterService::class);

        // If the user was subscribed and no longer desires anything, unsub them
        $wantsSomething = $user->mail_newsletter || $user->mail_vote || $user->mail_release;

        if ($newsletter->user($user)->isSubscribed() && !$wantsSomething) {
            $newsletter->remove();
        } elseif ($wantsSomething){
            $options = [
                'newsletters' => (bool) $user->mail_newsletter,
                'votes' => (bool) $user->mail_vote,
                'releases' => (bool) $user->mail_release
            ];

            $newsletter->update($options);
        }
    }
}

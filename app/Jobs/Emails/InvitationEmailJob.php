<?php


namespace App\Jobs\Emails;


use App\Mail\CampaignInviteMail;
use App\Mail\WelcomeEmail;
use App\Models\CampaignInvite;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class InvitationEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var int
     */
    public $inviteId;

    /**
     * @var int
     */
    public $userId;

    /**
     * @var string
     */
    public $language;

    /**
     * WelcomeEmailJob constructor.
     * @param User $user
     * @param string $language
     */
    public function __construct(CampaignInvite $campaignInvite, User $user, string $language = 'en')
    {
        $this->inviteId = $campaignInvite->id;
        $this->userId = $user->id;
        $this->language = $language;
    }

    public function handle()
    {
        /** @var CampaignInvite $invite */
        $invite = CampaignInvite::findOrFail($this->inviteId);
        $user = User::findOrFail($this->userId);
        Mail::to($invite->email)->send(
            new CampaignInviteMail(
                $user,
                $invite
            )
        );
    }
}

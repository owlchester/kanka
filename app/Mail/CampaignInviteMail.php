<?php

namespace App\Mail;

use App\Models\CampaignInvite;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CampaignInviteMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var User
     */
    public $user;

    /**
     * @var CampaignInviteMail
     */
    public $invite;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, CampaignInvite $campaignInvite)
    {
        $this->user = $user;
        $this->invite = $campaignInvite;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from(['address' => 'no-reply@kanka.io', 'name' => 'Kanko Support'])
            ->subject(trans('campaigns.invites.email.title', ['name' => e($this->user->name)]))
            ->view('emails.invite');
    }
}

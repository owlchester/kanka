<?php

namespace App\Mail;

use App\Models\Campaign;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CampaignExportMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var User
     */
    public $user;

    /**
     * @var Campaign
     */
    protected $campaign;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Campaign $campaign)
    {
        //
        $this->user = $user;
        $this->campaign = $campaign;
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
        ->subject(trans('campaigns.export.email.title', ['name' => e($this->campaign->name)]))
        ->view('emails.export');
    }
}

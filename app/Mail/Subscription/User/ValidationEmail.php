<?php

namespace App\Mail\Subscription\User;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ValidationEmail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public User $user;
    public string $url;


    public $date;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, string $url)
    {
        $this->user = $user;
        $this->url = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from(['address' => config('app.email'), 'name' => 'Kanka Team'])
            ->subject(__('emails/subscriptions/validation.title'))
            ->view('emails.subscriptions.validation.user-html')
            ->tag('validation');
    }
}

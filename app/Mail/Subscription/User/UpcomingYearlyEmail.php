<?php

namespace App\Mail\Subscription\User;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UpcomingYearlyEmail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * @var User
     */
    public $user;

    public $date;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->date = Carbon::now()->addMonth();
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
            ->subject(__('emails/subscriptions/upcoming.title'))
            ->view('emails.subscriptions.upcoming.user-html')
            ->tag('upcoming-yearly')
            ->text('emails.subscriptions.upcoming.user-text');
    }
}

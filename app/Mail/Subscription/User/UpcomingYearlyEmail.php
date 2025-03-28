<?php

namespace App\Mail\Subscription\User;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
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
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('emails/subscriptions/upcoming.title'),
            tags: ['user', 'upcoming-yearly'],
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.subscriptions.upcoming.user',
            with: ['user' => $this->user, 'date' => $this->date],
        );
    }
}

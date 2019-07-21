<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserDeleted extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var string Email
     */
    public $email;

    /**
     * @var int Id
     */
    public $id;

    /**
     * UserDeleted constructor.
     * @param int $userId
     * @param string $email
     */
    public function __construct(int $userId, string $email)
    {
        $this->id = $userId;
        $this->email = $email;
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
            ->subject('Account #' . $this->id . ' deleted - ' . $this->email)
            ->view('emails.goodbye');
    }
}

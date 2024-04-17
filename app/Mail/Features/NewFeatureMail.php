<?php

namespace App\Mail\Features;

use App\Models\Feature;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewFeatureMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * @var Feature
     */
    public $feature;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Feature $feature)
    {
        $this->feature = $feature;
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
            ->subject('New feature request')
            ->tag('admin-new-feature')
            ->view('emails.features.html');
    }
}

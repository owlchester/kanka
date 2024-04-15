<?php

namespace App\Jobs\Emails;

use App\Mail\Features\NewFeatureMail;
use App\Models\Feature;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NewFeatureEmailJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /** @var Feature */
    public $feature;

    /** @var int */
    public $tries = 3;

    /**
     * WelcomeEmailJob constructor.
     */
    public function __construct(Feature $feature)
    {
        $this->feature = $feature;
    }

    public function handle()
    {
        // Send an email to the admins
        Mail::to('hello@kanka.io')
            ->send(
                new NewFeatureMail($this->feature)
            );
    }
}

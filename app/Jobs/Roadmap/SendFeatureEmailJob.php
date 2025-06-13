<?php

namespace App\Jobs\Roadmap;

use App\Mail\Features\NewFeatureMail;
use App\Models\Feature;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendFeatureEmailJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Feature $feature,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to(config('app.email'))
            ->send(
                new NewFeatureMail($this->feature)
            );
    }
}

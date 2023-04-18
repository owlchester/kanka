<?php

namespace App\Jobs\Users;

use App\Services\NewsletterService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UnsubscribeUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $email)
    {
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /** @var NewsletterService $service */
        $service = app()->make(NewsletterService::class);
        $service->email($this->email)->delete();
        Log::info('Newsletter', ['action' => 'delete', 'email' => $this->email]);
    }
}

<?php

namespace App\Jobs\Discord;

use App\Models\AdminInvite;
use App\Services\Discord\NotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class AdminInviteJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public AdminInvite $adminInvite
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $webhook = config('discord.webhooks.admin');
        if (empty($webhook)) {
            return;
        }

        /** @var NotificationService $service */
        $service = app()->make(NotificationService::class);
        $service
            ->webhook($webhook)
            ->title('New support request')
            ->content('A new admin invite has been created')
            ->user($this->adminInvite->user)
            ->description('One of our users is in need of help and has generated an admin invite')
            ->url('https://admin.kanka.io/invites/' . $this->adminInvite->id)
            ->send();
    }
}

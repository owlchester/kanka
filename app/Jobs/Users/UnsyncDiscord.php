<?php

namespace App\Jobs\Users;

use App\Models\UserApp;
use App\Notifications\Header;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class UnsyncDiscord implements ShouldQueue
{
    use Queueable;

    public int $id;

    /**
     * Create a new job instance.
     */
    public function __construct(UserApp $app)
    {
        $this->id = $app->id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $app = UserApp::find($this->id);
        if (empty($app)) {
            return;
        }

        $app->delete();
        $app->user->notify(
            new Header(
                'apps.discord.invalid',
                'brands fa-discord',
                'warning',
                ['route' => 'settings.apps']
            ));
    }
}

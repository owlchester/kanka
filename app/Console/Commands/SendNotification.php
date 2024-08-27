<?php

namespace App\Console\Commands;

use App\Notifications\Header;
use App\Models\User;
use Illuminate\Console\Command;

class SendNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:notify {user=1} {url=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a test notification';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $userID = $this->argument('user');
        $url = $this->argument('url');

        if ($url !== '0') {
            $url = config('app.url') . '/pricing';
        }

        /** @var User $user */
        $user = User::findOrFail($userID);
        $user->notify(new Header('campaign.application.approved', 'download', 'info', ['link' => $url, 'campaign' => 'Fun & Games']));

        $this->info('User ' . $user->name . '#' . $user->id . ' notified.');
        return 0;
    }
}

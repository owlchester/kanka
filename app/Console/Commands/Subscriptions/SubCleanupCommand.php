<?php

namespace App\Console\Commands\Subscriptions;

use App\Jobs\SubscriptionEndJob;
use App\Models\User;
use Illuminate\Console\Command;

class SubCleanupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:cleanup {user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleanup the sub';

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

        /** @var User $user */
        $user = User::findOrFail($userID);

        SubscriptionEndJob::dispatch($user);

        $this->info('Sub cleaned up for user ' . $user->name . '#' . $user->id . '.');

        return 0;
    }
}

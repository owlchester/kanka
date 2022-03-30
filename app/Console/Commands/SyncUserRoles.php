<?php

namespace App\Console\Commands;

use App\Services\DiscordService;
use App\User;
use Illuminate\Console\Command;

class SyncUserRoles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:sync-discord {user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync a user\'s discord roles.';

    /** @var DiscordService */
    protected $service;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(DiscordService $service)
    {
        $this->service = $service;
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
        $user = User::find($userID);

        if ($user->apps()->app('discord')->count() === 0) {
            $this->error('User has no discord sync.');
            return 0;
        }

        $this->service->user($user)
            ->addRoles();

        $logs = $this->service->logs();
        foreach ($logs as $log) {
            $this->info($log);
        }
        return 0;
    }
}

<?php

namespace App\Console\Commands;

use App\Jobs\Emails\WelcomeEmailJob;
use Illuminate\Console\Command;

class TestEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:email {user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $userId = $this->argument('user');
        $user = \App\User::findOrFail($userId);

        WelcomeEmailJob::dispatch($user, 'en');
        return 0;
    }
}

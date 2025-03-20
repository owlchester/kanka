<?php

namespace App\Console\Commands\Users;

use App\Models\UserApp;
use App\Services\DiscordService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class RegenerateDiscordToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:renew-discord-tokens';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Renew a user\'s discord api token.';

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
        // $userID = $this->argument('user');

        $tokens = UserApp::select(['id', 'user_id', 'access_token', 'refresh_token', 'expires_at', 'updated_at'])
            ->with('user')
            ->where('app', '=', 'discord')
            ->where('expires_at', '<=', Carbon::now()->toDateString())
            ->get();

        if ($tokens->count() === 0) {
            $this->error('No tokens to renew');

            return 0;
        }

        foreach ($tokens as $token) {
            try {
                $this->service->user($token->user)->refresh();
            } catch (\Exception $e) {
                // Silence errors and ignore
            }
        }

        $logs = $this->service->logs();
        $this->service->log();

        foreach ($logs as $log) {
            $this->info($log);
        }

        return 0;
    }
}

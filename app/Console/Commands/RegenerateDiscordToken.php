<?php

namespace App\Console\Commands;

use App\Services\DiscordService;
use App\Models\User;
use Carbon\Carbon;
use App\Models\UserApp;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

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

    protected DiscordService $service;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //$userID = $this->argument('user');
        $this->service = app()->make(DiscordService::class);

        $tokens = UserApp::select(['id', 'user_id', 'access_token', 'refresh_token', 'expires_at', 'updated_at', 'settings'])
            ->with('user')
            ->where('app', '=', 'discord')
            ->where('expires_at', '<=', Carbon::now()->toDateString())
            ->get();

        if ($tokens->count() === 0) {
            $this->error('No tokens to renew');
            return 0;
        }

        $count = 0;
        foreach ($tokens as $token) {
            try {
                $this->service->user($token->user)->refresh();
                $count++;
            } catch (\Exception $e) {
                // Silence errors and ignore
            }
        }

        $logs = $this->service->logs();
        $this->service->log();

        foreach ($logs as $log) {
            $this->info($log);
        }

        $this->log('Renewed ' . $count . ' tokens.');

        return 0;
    }
}

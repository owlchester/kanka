<?php

namespace App\Console\Commands;

use App\Jobs\Users\DeleteUser;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class PurgeBots extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'purge:bots';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Purge bot accounts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        User::where('created_at', '>=', Carbon::now()->subDays(3))
            ->where(function ($sub) {
                $sub->where('name', 'like', '% Illuro');
            })
            ->chunk(500, function ($users) {
                foreach ($users as $user) {
                    if (Str::length($user->name) < 50) {
                        $this->log('Skipping ' . $user->id . ': ' . $user->name);
                        continue;
                    }
                    DeleteUser::dispatch($user);
                }
            });
    }
}

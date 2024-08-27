<?php

namespace App\Console\Commands;

use App\Jobs\Users\DeleteUser;
use App\Models\User;
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
    protected $signature = 'purge:bots {dry=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Purge bot accounts';

    protected int $count = 0;
    protected bool $dry = true;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dry = $this->argument('dry');
        if ($dry === '1') {
            $this->dry = false;
        }
        User::where('created_at', '>=', Carbon::now()->subDays(3))
            ->where(function ($sub) {
                $sub->where('name', 'like', '% Illuro');
            })
            ->chunkById(500, function ($users) {
                foreach ($users as $user) {
                    if (Str::length($user->name) < 50) {
                        $this->warn('Skipping ' . $user->id . ': ' . $user->name);
                        continue;
                    }
                    if (!$this->dry) {
                        DeleteUser::dispatch($user);
                    }
                    $this->count++;
                }
            });

        $this->info('Purged ' . $this->count . ' accounts');
    }
}

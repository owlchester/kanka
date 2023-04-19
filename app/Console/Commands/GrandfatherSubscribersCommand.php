<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class GrandfatherSubscribersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:grandfather';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Grandfather subscribers on the old system';

    protected int $count = 0;

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        User::select(['id', 'settings'])
            ->where('booster_count', '>=', 0)
            ->orWhere(function ($sub) {
                return $sub
                    ->whereNotNull('pledge')
                    ->where('pledge', '!=', '')
                ;
            })
            ->chunk(500, function ($users): void {
                foreach ($users as $user) {
                    /** @var User $user */
                    $settings = $user->settings;
                    $settings['grandfathered_boost'] = 1;
                    $user->settings = $settings;
                    $user->saveQuietly();
                    $this->count++;
                }
            });
        $this->info('Grandfathered ' . $this->count . ' subscribers');
    }
}

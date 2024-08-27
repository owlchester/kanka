<?php

namespace App\Console\Commands\Migrations;

use App\Models\User;
use Illuminate\Console\Command;

class MigrateUserPreferences extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:migrate-layout';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate user layout settings';

    private $count = 0;
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        User::whereNotNull('default_pagination')
            ->orWhereNotNull('date_format')
            ->orWhereNotNull('currency')
            ->chunk(5000, function ($users): void {
                /** @var User $user */
                foreach ($users as $user) {
                    $this->count++;

                    $settings = $user->settings;
                    if (!empty($user->date_format)) {
                        $settings['date_format'] = $user->date_format;
                    }
                    if (!empty($user->default_pagination)) {
                        $settings['pagination'] = $user->default_pagination;
                    }
                    if (!empty($user->currency)) {
                        $settings['currency'] = $user->currency;
                    }
                    $user->updateQuietly(['settings' => $settings]);
                }
            });

        $this->info('Migrated ' . $this->count . ' users.');
        return Command::SUCCESS;
    }
}

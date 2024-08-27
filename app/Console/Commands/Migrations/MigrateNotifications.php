<?php

namespace App\Console\Commands\Migrations;

use App\Models\Notification;
use Illuminate\Console\Command;

class MigrateNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:migrate-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate user notifications';

    private $count = 0;
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Notification::where('notifiable_type', 'App\User')
            ->chunk(5000, function ($notifications): void {
                /** @var Notification $notification */
                foreach ($notifications as $notification) {
                    $this->count++;
                    $notification->updateQuietly(['notifiable_type' => 'App\Models\User']);
                }
            });

        $this->info('Migrated ' . $this->count . ' user notifications.');
        return Command::SUCCESS;
    }
}

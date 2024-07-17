<?php

namespace App\Console\Commands\Migrations;

use App\Models\Users\Tutorial;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MigrateTutorials extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:migrate-tutorials';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate user tutorial settings';

    private $count = 0;
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        User::whereNotNull('settings')
            ->chunk(5000, function ($users): void {
                /** @var User $user */
                foreach ($users as $user) {
                    $this->count++;
                    $settings = $user->settings;

                    foreach ($settings as $key => $setting) {
                        if (Str::startsWith($key, ['tutorial_', 'banner_'])) {
                            $tutorial = new Tutorial();
                            $tutorial->user_id = $user->id;
                            $tutorial->code = mb_substr($key, 9);
                            $tutorial->save();
                            unset($settings[$key]);
                        } elseif(str_starts_with($key, 'releases_')) {
                            $tutorial = new Tutorial();
                            $tutorial->user_id = $user->id;
                            $tutorial->code = $key . '_' . $setting;
                            $tutorial->save();
                            unset($settings[$key]);
                        }
                    }
                    $user->updateQuietly(['settings' => $settings]);
                }
            });

        $this->info('Migrated ' . $this->count . ' user tutorials.');
        return Command::SUCCESS;
    }
}

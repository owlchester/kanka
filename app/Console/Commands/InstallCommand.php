<?php
namespace App\Console\Commands;
use App\Models\EntityType;
use Exception;
use Illuminate\Console\Command;
class InstallCommand extends Command
{
    protected $signature = 'kanka:install';
    protected $description = 'Set up Kanka\'s boilerplate';

    public function handle()
    {
        try {
            if (EntityType::find(1)) {
                $this->error('Kanka has already been installed.');
                $this->info('Check it out at ' . config('app.url') . ':' . env('APP_PORT'));
                return;
            }
        } catch (Exception) {
        }

        // Only generate key if not already set
        if (empty(config('app.key'))) {
            $this->call('key:generate');
        } else {
            $this->info('APP_KEY already set, skipping key generation.');
        }

        $this->call('migrate');
        $this->call('db:seed');
        $this->call('passport:install');
        $this->info('Kanka successfully installed.');
        $this->info('Check it out at ' . config('app.url') . ':' . env('APP_PORT'));
    }
}

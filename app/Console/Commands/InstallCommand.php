<?php

namespace App\Console\Commands;

use App\Models\EntityType;
use Exception;
use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kanka:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set up Kanka\'s boilerplate';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            if (EntityType::find(1)) {
                $this->error('Kanka has already been installed.');

                return;
            }
        } catch (Exception) {
        }
        $this->call('key:generate');
        $this->call('migrate');
        $this->call('db:seed');
        $this->call('passport:install');

        $this->info('Kanka successfully installed.');
        $this->info('Check it out at ' . config('app.url'));
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Testing\PendingCommand;
use Illuminate\Support\Facades\Artisan;

class SetupTestDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setupTestDB';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup the TestDB';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!isset($_ENV['APP_ENV']) || $_ENV['APP_ENV'] !== 'testing') {
            echo $_ENV['APP_ENV'];
            echo "run with --env=testing";
            return 0;
        }

        $mysql = mysqli_connect($_ENV['DB_HOST'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], '', $_ENV['DB_PORT']);
        $mysql->query('DROP DATABASE IF EXISTS `' . $_ENV['DB_DATABASE'] . '`');
        $mysql->query('CREATE DATABASE `' . $_ENV['DB_DATABASE'] . '`');

        /** @var PendingCommand $tets */
        Artisan::call('migrate:fresh', ['--drop-views' => true]);
    }
}

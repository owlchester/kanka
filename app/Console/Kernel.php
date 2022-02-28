<?php

namespace App\Console;

use App\Console\Commands\CalendarAdvancer;
use App\Console\Commands\CampaignVisibileEntityCount;
use App\Console\Commands\CleanupEntityLogs;
use App\Console\Commands\CleanupEntityUsers;
use App\Console\Commands\CleanupTrashed;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();

        $schedule->command(CalendarAdvancer::class)->dailyAt('00:00');
        $schedule->command(CampaignVisibileEntityCount::class)->dailyAt('01:00');
        $schedule->command(CleanupEntityLogs::class)->dailyAt('03:30');
        $schedule->command(CleanupEntityUsers::class)->dailyAt('03:35');
        $schedule->command(CleanupTrashed::class)->dailyAt('02:15');

        $schedule->command('backup:clean')->daily()->at('01:00');
        $schedule->command('backup:run')->twiceDaily(2, 14);
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

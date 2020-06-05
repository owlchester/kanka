<?php

namespace App\Console;

use App\Console\Commands\CalendarAdvancer;
use App\Console\Commands\CampaignVisibileEntityCount;
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
        //$schedule->command(CleanupTrashed::class)->dailyAt('04:00');

        $schedule->command('db:backup --database=mysql --destination=s3 --compression=gzip --destinationPath=prod/ --timestamp="d-m-Y H"')->twiceDaily(2, 14);
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

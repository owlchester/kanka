<?php

namespace App\Console;

use App\Console\Commands\Campaigns\VisibileEntityCountCommand;
use App\Console\Commands\Cleanup\AnonymiseUserLogs;
use App\Console\Commands\Cleanup\CleanupEntityLogs;
use App\Console\Commands\Cleanup\CleanupTrashed;
use App\Console\Commands\Cleanup\CleanupTrashedCampaigns;
use App\Console\Commands\Cleanup\CleanupUsers;
use App\Console\Commands\Entities\CalendarAdvancer;
use App\Console\Commands\Report\Accounts;
use App\Console\Commands\Report\Churn;
use App\Console\Commands\Report\Onboarding;
use App\Console\Commands\Report\Weekly;
use App\Console\Commands\Subscriptions\EndFreeTrials;
use App\Console\Commands\Subscriptions\EndSubscriptions;
use App\Console\Commands\Subscriptions\ExpiringCardCommand;
use App\Console\Commands\Users\RegenerateDiscordToken;
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

    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command(ExpiringCardCommand::class)->onOneServer()->monthly();
        $schedule->command('model:prune')->onOneServer()->daily();
        $schedule->command(CalendarAdvancer::class)->onOneServer()->daily();
        $schedule->command(AnonymiseUserLogs::class)->onOneServer()->daily();
        $schedule->command(EndSubscriptions::class)->onOneServer()->dailyAt('00:05')->sentryMonitor();
        $schedule->command(EndFreeTrials::class)->onOneServer()->dailyAt('00:01');
        $schedule->command(RegenerateDiscordToken::class)->onOneServer()->dailyAt('00:15');
        $schedule->command(VisibileEntityCountCommand::class)->onOneServer()->dailyAt('01:00');
        $schedule->command(CleanupTrashed::class)->onOneServer()->dailyAt('01:15');
        $schedule->command('backup:clean')->onOneServer()->dailyAt('01:20');
        $schedule->command(CleanupEntityLogs::class)->onOneServer()->dailyAt('01:30');
        $schedule->command(CleanupTrashedCampaigns::class)->onOneServer()->dailyAt('01:45');
        // $schedule->command(CleanupUsers::class)->onOneServer()->dailyAt('01:50');
        $schedule->command('backup:run')->onOneServer()->twiceDaily(2, 14);

        // $schedule->command(Onboarding::class)->onOneServer()->weekly();
        $schedule->command(Churn::class)->onOneServer()->weekly();
        // $schedule->command(Accounts::class)->onOneServer()->weekly();
        $schedule->command(Weekly::class)->onOneServer()->weekly();

        // $schedule->command('backup:monitor')->daily()->at('03:00');
        // $schedule->command(UpcomingYearlyCommand::class)->dailyAt('06:30');

    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}

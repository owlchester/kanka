<?php

namespace App\Console\Commands\Report;

use App\Jobs\Discord\ReportJob;
use App\Services\Report\WeeklyReportService;
use Illuminate\Console\Command;

class Weekly extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:weekly {--days=7}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new weekly report';

    /**
     * Execute the console command.
     */
    public function handle(WeeklyReportService $service): void
    {
        $days = (int) $this->option('days');

        // Ex: Feb 10-16, 2026
        $period = now()->subDays($days)->format('M j') . '-' . now()->format('j, Y');

        $current = $service->getStats(now()->subDays($days), now());
        $previous = $service->getStats(now()->subDays($days * 2), now()->subDays($days));

        $title = "**{$service->name()}** - $period";

        $this->info($title);
        $this->info(str_repeat('=', 60));
        $this->newLine();

        foreach ($service->buildTerminalLines($current, $previous) as $line) {
            $this->line($line);
        }

        ReportJob::dispatch($title, $service->buildDiscordBody($current, $previous));
    }
}

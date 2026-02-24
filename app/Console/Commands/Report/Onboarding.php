<?php

namespace App\Console\Commands\Report;

use App\Jobs\Discord\ReportJob;
use App\Services\Report\OnboardingReportService;
use Illuminate\Console\Command;

class Onboarding extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:onboarding {--days=7}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate onboarding funnel report';

    /**
     * Execute the console command.
     */
    public function handle(OnboardingReportService $service): void
    {
        $days = (int) $this->option('days');

        $current = $service->getStats(now()->subDays($days), now());
        $previous = $service->getStats(now()->subDays($days * 2), now()->subDays($days));

        $title = "{$service->name()} (Last {$days} days)";

        $this->info($title);
        $this->info(str_repeat('=', 60));
        $this->newLine();

        foreach ($service->buildTerminalLines($current, $previous) as $line) {
            $this->line($line);
        }

        ReportJob::dispatch($title, $service->buildDiscordBody($current, $previous));
    }
}

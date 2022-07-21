<?php

namespace App\Console\Commands;

use App\Models\JobLog;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CleanupJobLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleanup:job-logs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleanup old job logs';

    /** @var int Number of processed elements */
    protected int $count = 0;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->count = JobLog::where('created_at', '<=', Carbon::now()->subMonths(2)->toDateString())
            ->delete();
        $this->info('Cleaned up ' . $this->count . ' job logs.');

        return 0;
    }
}

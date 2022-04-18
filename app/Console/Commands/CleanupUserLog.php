<?php

namespace App\Console\Commands;

use App\Models\UserLog;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CleanupUserLog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleanup:user-logs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleanup old user logs';

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
        $this->count = UserLog::where('created_at', '<=', Carbon::now()->subMonths(6)->toDateString())
            ->delete();

        $this->info('Cleaned up ' . $this->count . ' user logs.');
        return 0;
    }
}

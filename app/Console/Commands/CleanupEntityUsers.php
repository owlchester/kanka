<?php

namespace App\Console\Commands;

use App\Models\EntityUser;
use App\Models\JobLog;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CleanupEntityUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleanup:entity-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleanup old entity-user entries';

    /** @var int number of cleaned up logs */
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
        $this->count = EntityUser::keepAlive()
            ->where('updated_at', '<=', Carbon::now()->subDays(1)->toDateString())
            ->delete();
        $log = "Cleaned up {$this->count} entity users.";
        $this->info($log);

        if (!config('app.log_jobs')) {
            return 0;
        }

        JobLog::create([
            'name' => $this->signature,
            'result' => $log,
        ]);
        return 0;
    }
}

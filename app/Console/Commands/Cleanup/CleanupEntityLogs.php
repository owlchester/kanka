<?php

namespace App\Console\Commands\Cleanup;

use App\Models\EntityLog;
use App\Traits\HasJobLog;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CleanupEntityLogs extends Command
{
    use HasJobLog;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleanup:entity-logs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleanup entity log details';

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
     */
    public function handle()
    {
        $amount = config('entities.logs');

        /**
         * We don't delete logs here (that's handled by the MassPrunable trait), but instead, we remove
         * the changelogs that are available to superboosted campaigns for up to $amount(30) days.
         */
        EntityLog::where('created_at', '<=', Carbon::now()->subDays($amount)->toDateString())
            ->whereNotNull('changes')
            ->chunkById(100, function ($models): void {
                $entityIds = [];
                foreach ($models as $model) {
                    $entityIds[] = $model->id;
                    $this->count++;
                }

                $statement = 'UPDATE entity_logs SET changes = null WHERE id in(' .
                    implode(', ', $entityIds) .
                ') limit ' . count($entityIds);
                DB::statement($statement);
            });
        $log = "Cleaned up {$this->count} entity logs.";
        $this->info($log);
        $this->log($log);

        return 0;
    }
}

<?php

namespace App\Console\Commands;

use App\Models\EntityLog;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CleanupEntityLogs extends Command
{
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

    protected $count = 0;

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
     * @return mixed
     */
    public function handle()
    {
        EntityLog::
            where('updated_at', '<=', Carbon::now()->subDays(30)->toDateString())
            ->whereNotNull('changes')
            ->chunk(100, function ($models) {
                $entityIds = [];
                foreach ($models as $model) {
                    $entityIds[] = $model->id;
                    $this->count++;
                }

                $statement = 'UPDATE entity_logs SET changes = null WHERE id in(' .
                    implode(', ', $entityIds) .
                ') limit 100';
                DB::statement($statement);
            });

        $this->info('Cleaned up ' . $this->count . ' entity logs.');
    }
}

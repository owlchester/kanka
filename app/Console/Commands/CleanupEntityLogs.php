<?php

namespace App\Console\Commands;

use App\Models\EntityLog;
use App\Models\JobLog;
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
     * @return mixed
     */
    public function handle()
    {
        $amount = config('entities.logs');
        $delay = config('entities.logs_delete');
        EntityLog::
            where('created_at', '<=', Carbon::now()->subDays($amount)->toDateString())
            ->whereNotNull('changes')
            ->chunk(100, function ($models) {
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

        DB::beginTransaction();
        try {
            $this->count = EntityLog::
                where('updated_at', '<=', Carbon::now()->subDays($delay)->toDateString())
                ->delete();
            DB::commit();
        } catch (\Exception $e) {
            $this->error($e->getMessage());
            DB::rollBack();
        }
        $this->info('Cleaned up ' . $this->count . ' entity logs.');
        $log .= '<br />' . 'Cleaned up ' . $this->count . ' entity logs.';
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

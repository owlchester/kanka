<?php

namespace App\Console\Commands\Cleanup;

use App\Models\Entity;
use App\Services\RecoveryService;
use App\Traits\HasJobLog;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CleanupTrashed extends Command
{
    use HasJobLog;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleanup:trashed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete old trashed entities';

    /**
     * The recovery service
     *
     */
    protected RecoveryService $service;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(RecoveryService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $delay = Carbon::now()->subDays(config('entities.hard_delete'))->toDateString();
        $log = '';

        DB::beginTransaction();
        try {
            Entity::onlyTrashed()
                ->where('deleted_at', '<=', $delay)
                ->allCampaigns()
                // chunkById allows us to safely delete elements in a chunk
                // see https://stackoverflow.com/questions/32700537/eloquent-chunk-missing-half-the-results
                ->chunkById(1000, function ($entities): void {
                    $this->info('Chunk deleting ' . count($entities) . ' entities.');
                    foreach ($entities as $entity) {
                        //dump($entity->name . ' (' . $entity->type() . ')');
                        $this->service->trash($entity);
                    }
                });
            DB::commit();
        } catch (Exception $e) {
            $this->error($e->getMessage());
            $log .= '<br />' . $e->getMessage();
            DB::rollBack();
        }

        $this->info('');
        $this->info('Deleted ' . $this->service->count() . ' trashed entities.');
        $log .= '<br />' . 'Deleted ' . $this->service->count() . ' trashed entities.';

        $this->log($log);

        return 0;
    }
}

<?php

namespace App\Console\Commands;

use App\Models\Entity;
use App\Models\MiscModel;
use App\Models\JobLog;
use App\Services\RecoveryService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CleanupTrashed extends Command
{
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
     * @var RecoveryService
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
     * @return mixed
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
                ->chunkById(1000, function ($entities) {
                    $this->info('Chunk deleting ' . count($entities) . ' entities.');
                    foreach ($entities as $entity) {
                        //dump($entity->name . ' (' . $entity->type() . ')');
                        $this->service->trash($entity);
                    }
                });
            DB::commit();
        } catch (\Exception $e) {
            $this->error($e->getMessage());
            $log .= '<br />' . $e->getMessage();
            DB::rollBack();
        }

        $this->info('');
        $this->info('Deleted ' . $this->service->count() . ' trashed entities.');
        $log .= '<br />' . 'Deleted ' . $this->service->count() . ' trashed entities.';

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

<?php

namespace App\Console\Commands;

use App\Models\Entity;
use App\Models\MiscModel;
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
    protected $signature = 'cleanup:trashed {types=map} {limit=0}';

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
    protected $service;

    protected $limit = null;

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
        $types = $this->argument('types');
        $this->limit = $this->argument('limit');
        $typeList = explode(',', $types);
        $entityTypeIDs = [];
        foreach ($typeList as $entityType) {
            if ($entityType === 'all') {
                continue;
            }
            $id = config('entities.ids.' . $entityType);
            if (empty($id)) {
                $this->warn('Unknown entity type ' . $entityType);
                continue;
            }
            $entityTypeIDs[] = $id;
        }

        $this->info('Looking for deleted entities (' . $types . ') where deleted_at <= ' . $delay);
        if (!empty($this->limit)) {
            $this->info('- Limit: ' . $this->limit);
        }

        // Stats stuff for developing
        $entityCount = $endEntityCount = 0;
        if ($types !== 'all') {
            $firstType = Arr::first($typeList);
            $firstTypeTable = Str::plural($firstType);
            $firstTypeID = Arr::first($entityTypeIDs);

            $res = DB::table($firstTypeTable)
                ->select(DB::raw('count(*) as tot'))
                ->get();
            $this->info('Total ' . $firstTypeTable . ' ' . number_format($res[0]->tot, 0, '.', '\''));
            $res = DB::table('entities')
                ->select(DB::raw('count(*) as tot'))
                ->where('type_id', $firstTypeID)
                ->get();
            $entityCount = $res[0]->tot;
            $this->info('Total entities (type_id=' . $firstTypeID . ')' . number_format($entityCount, 0, '.', '\''));
        }

        // Dump each time a query is made
        DB::listen(function($query) {
            //if (Str::startsWith($query->sql, "select * from `entities` where `type` in")) {
            //    dump(Str::replaceArray('?', $query->bindings, $query->sql));
            //}
        });

        DB::beginTransaction();
        try {
            Entity::inTypes($entityTypeIDs)
                ->onlyTrashed()
                ->where('deleted_at', '<=', $delay)
                ->allCampaigns()
                // chunkById allows us to safely delete elements in a chunk
                // see https://stackoverflow.com/questions/32700537/eloquent-chunk-missing-half-the-results
                ->chunkById(1000, function ($entities) {
                    if (!empty($this->limit) && $this->service->count() >= $this->limit) {
                        return;
                    }
                    $this->info('Chunk deleting ' . count($entities) . ' entities.');
                    foreach ($entities as $entity) {
                        //dump($entity->name . ' (' . $entity->type() . ')');
                        $this->service->trash($entity);
                    }
                });
            DB::commit();
        } catch (\Exception $e) {
            $this->error($e->getMessage());
            DB::rollBack();
        }

        $this->info('');
        $this->info('Deleted ' . $this->service->count() . ' trashed entities.');

        // Stats checkup for developing
        if ($types !== 'all') {
            $res = DB::table($firstTypeTable)
                ->select(DB::raw('count(*) as tot'))
                ->get();
            $this->info('Total ' . $firstTypeTable . ' ' . number_format($res[0]->tot, 0, '.', '\''));
            $res = DB::table('entities')
                ->select(DB::raw('count(*) as tot'))
                ->where('type_id', $firstTypeID)
                ->get();
            $endEntityCount = $res[0]->tot;
            $this->info('Total entities (type_id=' . $firstTypeID . ') ' . number_format($endEntityCount, 0, '.', '\''));

            if ($entityCount - $this->service->count() !== $endEntityCount) {
                $this->error('Entity count mismatch ' . $entityCount . ' - ' . $this->service->count() . ' != ' . $endEntityCount);

            }
        }

        return true;
    }
}


/**
 * All x
 * Ability x
 * AttrTemp (by all)
 * Event x
 * Family x
 * Journal x
 * Location x
 * Map x
 * Note x
 * Organisation x
 * Timeline x
 */

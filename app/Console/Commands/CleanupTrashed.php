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
    protected $signature = 'cleanup:trashed {types=all}';

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
        $typeList = explode(',', $types);
        $firstType = Arr::first($typeList);
        $firstTypeTable = Str::plural($firstType);

        $this->info('Looking for deleted entities (' . $types . ') where deleted_at <= ' . $delay);

        // Stats stuff for developing
        $entityCount = $endEntityCount = 0;
        if ($firstType !== 'all') {
            $res = DB::table($firstTypeTable)
                ->select(DB::raw('count(*) as tot'))
                ->get();
            $this->info('Total ' . $firstTypeTable . ' ' . number_format($res[0]->tot, 0, '.', '\''));
            $res = DB::table('entities')
                ->select(DB::raw('count(*) as tot'))
                ->where('type', $firstType)
                ->get();
            $entityCount = $res[0]->tot;
            $this->info('Total entities ' . number_format($entityCount, 0, '.', '\''));
        }

        // Dump each time a query is made
        DB::listen(function($query) {
            //if (Str::startsWith($query->sql, "select * from `entities` where `type` in")) {
            //    dump(Str::replaceArray('?', $query->bindings, $query->sql));
            //}
        });

        DB::beginTransaction();
        try {
            Entity::inTypes($typeList)
                ->onlyTrashed()
                ->where('deleted_at', '<=', $delay)
                ->allCampaigns()
                // chunkById allows us to safely delete elements in a chunk
                // see https://stackoverflow.com/questions/32700537/eloquent-chunk-missing-half-the-results
                ->chunkById(1000, function ($entities) {
                    $this->info('Chunk deleting ' . count($entities) . ' entities.');
                    foreach ($entities as $entity) {
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
        if ($firstType !== 'all') {
            $res = DB::table($firstTypeTable)
                ->select(DB::raw('count(*) as tot'))
                ->get();
            $this->info('Total ' . $firstTypeTable . ' ' . number_format($res[0]->tot, 0, '.', '\''));
            $res = DB::table('entities')
                ->select(DB::raw('count(*) as tot'))
                ->where('type', $firstType)
                ->get();
            $endEntityCount = $res[0]->tot;
            $this->info('Total entities ' . number_format($endEntityCount, 0, '.', '\''));

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

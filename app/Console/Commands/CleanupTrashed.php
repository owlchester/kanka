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

        $miscCount = $entityCount = $endMiscCount = $endEntityCount = 0;


        $this->info('Looking for deleted entities (' . $types . ') where deleted_at <= ' . $delay);

        if ($firstType !== 'all') {
            $res = DB::table($firstTypeTable)
                ->select(DB::raw('count(*) as tot'))
                ->get();
            $miscCount = $res[0]->tot;
            $this->info('Total ' . $firstTypeTable . ' ' . number_format($miscCount, 0, '.', '\''));
            $res = DB::table('entities')
                ->select(DB::raw('count(*) as tot'))
                ->where('type', $firstType)
                ->get();
            $entityCount = $res[0]->tot;
            $this->info('Total entities ' . number_format($entityCount, 0, '.', '\''));
        }

        // Dump each time a query is made
        /*DB::listen(function($query) {
            dump(Str::replaceArray('?', $query->bindings, $query->sql));
        });*/

            Entity::
            inTypes($typeList)
                ->onlyTrashed()
                ->where('deleted_at', '<=', $delay)
                ->allCampaigns()
                ->chunk(100, function ($entities) {

                    DB::beginTransaction();

                    try {
                        foreach ($entities as $entity) {
                            $this->service->trash($entity);
                        }
                        DB::commit();
                        $this->info('Chunk deleted ' . count($entities) . ' entities.');
                    } catch (\Exception $e) {
                        $this->error($e->getMessage());
                        DB::rollBack();
                    }
                });

        $this->info('');
        $this->info('Deleted ' . $this->service->count() . ' trashed entities.');

        if ($firstType !== 'all') {
            $res = DB::table($firstTypeTable)
                ->select(DB::raw('count(*) as tot'))
                ->get();
            $endMiscCount = $res[0]->tot;
            $this->info('Total ' . $firstTypeTable . ' ' . number_format($endMiscCount, 0, '.', '\''));
            $res = DB::table('entities')
                ->select(DB::raw('count(*) as tot'))
                ->where('type', $firstType)
                ->get();
            $endEntityCount = $res[0]->tot;
            $this->info('Total entities ' . number_format($endEntityCount, 0, '.', '\''));

            if ($miscCount - $this->service->count() !== $endMiscCount) {
                $this->error('Misc count mismatch');
            }
            if ($entityCount - $this->service->count() !== $endEntityCount) {
                $this->error('Misc count mismatch');
            }
        }

        return true;
    }
}


/**
 * Ability
 * AttrTemp
 * Event
 * Family x
 * Journal
 * Location x
 * Map x
 * Note
 * Organisation
 * Timeline
 */

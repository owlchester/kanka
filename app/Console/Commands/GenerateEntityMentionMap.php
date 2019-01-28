<?php

namespace App\Console\Commands;

use App\Models\Campaign;
use App\Models\Entity;
use App\Models\EntityMention;
use App\Models\EntityNote;
use App\Models\MiscModel;
use App\Services\EntityMappingService;
use App\Services\EntityService;
use Illuminate\Console\Command;

class GenerateEntityMentionMap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'entity:mention-map';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the entity mentions map.';

    /**
     * @var int
     */
    protected $entityCount = 0;
    protected $mapCount = 0;

    /**
     * @var EntityMappingService
     */
    protected $entityMapping;

    /**
     * GenerateEntityMentionMap constructor.
     * @param EntityMappingService $entityMappingService
     */
    public function __construct(EntityMappingService $entityMappingService)
    {
        parent::__construct();
        $this->entityMapping = $entityMappingService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $entities = [
            //'App\Models\Campaign',
            'App\Models\Character',
            'App\Models\Calendar',
            'App\Models\Event',
            'App\Models\Family',
            'App\Models\Item',
            'App\Models\Journal',
            'App\Models\Location',
            'App\Models\Note',
            'App\Models\Organisation',
            'App\Models\Quest',
            'App\Models\Tag',
        ];
        $this->entityMapping->verbose = true;

        // Cleanup any existing mentions
        EntityMention::truncate();

        foreach ($entities as $entity) {
            $model = new $entity;
            $model->with('entity')->where('entry', 'like', '%data-toggle="tooltip"%')->chunk(5000, function ($models) use ($entity) {
                foreach ($models as $model) {
                    $this->entityCount++;
                    /** @var MiscModel $model */
                    $this->info("Checking " . $model->getTable() . ":" . $model->id);
                    $this->mapCount += $this->entityMapping->mapModel($model);
                }
            });
        }

        // Entity Notes
        EntityNote::where('entry', 'like', '%data-toggle="tooltip"%')->chunk(5000, function ($models) use ($entity) {
            foreach ($models as $model) {
                $this->entityCount++;
                /** @var EntityNote $model */
                $this->info("Checking entity_note:" . $model->id);
                $this->mapCount += $this->entityMapping->mapEntityNote($model);
            }
        });

        // Entity Notes
        Campaign::where('entry', 'like', '%data-toggle="tooltip"%')->chunk(5000, function ($models) use ($entity) {
            foreach ($models as $model) {
                $this->entityCount++;
                /** @var EntityNote $model */
                $this->info("Checking campaign:" . $model->id);
                $this->mapCount += $this->entityMapping->mapCampaign($model);
            }
        });

        $this->info("Updated {$this->entityCount} entities and created {$this->mapCount} maps.");

        return true;
    }
}

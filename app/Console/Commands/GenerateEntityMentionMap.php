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
    protected $mapTotalCount = 0;
    protected $redirectFixed = 0;

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
        $start = date('H:i:s');
        $this->info("START " . $start);
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
            $this->info("Entity $entity");
            // Let's first fix those awful redirects
            $this->redirectFixed = 0;
            $model = new $entity;
            $model->with('entity')->where('entry', 'like', '%redirect?what=%')->chunk(1000, function ($models) use ($entity) {
                foreach ($models as $model) {
                    /** @var MiscModel $model */
                    $pattern = '<a href="([^"]*)">(.*?)&lt;(.*?)&gt;';
                    $model->entry = preg_replace("`$pattern`i", '<a href="$1">$2</a>', $model->entry);
                    if ($model->isDirty('entry')) {
                        $this->redirectFixed++;
                        $model->timestamps = false;
                        $model->save();
                    }
                }
            });
            $this->info("- Fixed {$this->redirectFixed} redirects.");
            $this->mapTotalCount += $this->mapCount;

            // Mapping
            $this->mapCount = 0;
            $model = new $entity;
            $model->with('entity')->where('entry', 'like', '%data-toggle="tooltip"%')->chunk(5000, function ($models) use ($entity) {
                $bar = $this->output->createProgressBar(count($models));
                $bar->start();
                foreach ($models as $model) {
                    $this->entityCount++;
                    /** @var MiscModel $model */
                    //$this->info("Checking " . $model->getTable() . ":" . $model->id);
                    $this->mapCount += $this->entityMapping->mapModel($model);
                    $bar->advance();
                }
                $bar->finish();
            });
            $this->info("- Created {$this->mapCount} maps.\n");
            $this->mapTotalCount += $this->mapCount;
        }

        // Entity Notes
        $this->info("Entity Notes");
        $this->mapCount = 0;
        EntityNote::where('entry', 'like', '%data-toggle="tooltip"%')->chunk(5000, function ($models) {
            $bar = $this->output->createProgressBar(count($models));
            $bar->start();
            foreach ($models as $model) {
                $this->entityCount++;
                /** @var EntityNote $model */
                //$this->info("Checking entity_note:" . $model->id);
                $this->mapCount += $this->entityMapping->mapEntityNote($model);
                $bar->advance();
            }
            $bar->finish();
        });
        $this->info("- Created {$this->mapCount} maps.\n");
        $this->mapTotalCount += $this->mapCount;

        // Campaigns
        $this->info("Campaigns");
        $this->mapCount = 0;
        Campaign::where('entry', 'like', '%data-toggle="tooltip"%')->chunk(5000, function ($models) {
            $bar = $this->output->createProgressBar(count($models));
            $bar->start();
            foreach ($models as $model) {
                $this->entityCount++;
                /** @var Campaign $model */
                //$this->info("Checking campaign:" . $model->id);
                $this->mapCount += $this->entityMapping->mapCampaign($model);
                $bar->advance();
            }
            $bar->finish();
        });
        $this->info("- Created {$this->mapCount} maps.\n");
        $this->mapTotalCount += $this->mapCount;

        $this->info("Updated {$this->entityCount} entities and created {$this->mapTotalCount} maps.");
        $this->info("END " . date('H:i:s') . " ($start)");

        return true;
    }
}

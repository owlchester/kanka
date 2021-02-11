<?php

namespace App\Console\Commands;

use App\Models\Ability;
use App\Models\Event;
use App\Models\Family;
use App\Models\Journal;
use App\Models\Location;
use App\Models\Organisation;
use App\Models\Quest;
use App\Models\Race;
use App\Models\Tag;
use App\Models\Timeline;
use App\Services\EntityService;
use Illuminate\Console\Command;

class GenerateTrees extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trees {models=all,timelines,journals}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the trees';

    /** @var EntityService */
    protected $service;

    public function __construct(EntityService $service)
    {
        $this->service = $service;
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $models = explode(',', $this->argument('models'));

        if ($this->argument('models') === 'all') {
            $this->fixAll();
            $this->info('Finished');
            return 1;
        }

        foreach ($models as $model) {
            $class = $this->service->getClass($model);
            if ($class === false) {
                $this->warn('Skipping ' . $model);
                continue;
            }
            $this->info("Fixing $model");
            $class::fixTree();

        }
        $this->info('Finished');
    }

    /**
     *
     */
    protected function fixAll()
    {
        $models = $this->service->entities();
        foreach ($models as $model => $class) {
            $new = new $class;
            try {
                $parentTreeField = $new->getParentIdName();
                $this->info("Fixing $model");
                $class::fixTree();
            } catch (\Exception $e) {
                $this->warn('Skipping ' . $model);
            }

        }
    }
}

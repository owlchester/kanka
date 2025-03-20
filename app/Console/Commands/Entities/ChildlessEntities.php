<?php

namespace App\Console\Commands\Entities;

use App\Models\Entity;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ChildlessEntities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'entities:childless';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find entities with no children';

    protected $traces = [];

    protected $total = 0;

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
     * @return int
     */
    public function handle()
    {
        $entities = [];
        $types = config('entities.ids');
        foreach ($types as $type => $id) {
            $entities[] = $type;
        }

        foreach ($entities as $type) {
            $plural = Str::plural($type);
            $this->info('checking ' . $plural);

            Entity::select('entities.*')
                ->where('entities.type', $type)
                ->leftJoin($plural . ' as f', 'f.id', 'entities.entity_id')
                ->whereNull('f.id')
                ->with(Str::camel($type))
                ->chunk(1000, function ($models) use ($type): void {
                    foreach ($models as $model) {
                        $this->trace($model, $type);
                    }

                    if (! empty($this->traces)) {
                        $this->info(implode(', ', $this->traces));
                        $this->traces = [];
                    }
                });

            $this->info('');
        }

        $this->warn('Found ' . $this->total . ' childless entities.');

        return 0;
    }

    protected function trace(Entity $entity, string $type): void
    {
        $this->traces[] = $entity->id;
        $this->total++;

        /*if (count($this->traces) > 100) {
            $this->info(implode(', ', $this->traces));
            $this->traces = [];
        }*/
    }
}

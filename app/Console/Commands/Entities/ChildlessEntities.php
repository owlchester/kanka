<?php

namespace App\Console\Commands\Entities;

use App\Models\Entity;
use App\Models\EntityType;
use App\Models\Scopes\ActiveEntityScope;
use Illuminate\Console\Command;

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
        $this->total = 0;
        $types = EntityType::default()->where('is_special', false)->where('code', '!=', 'bookmark')->get();

        foreach ($types as $type) {
            $this->info('checking ' . $type->code);
            $class = $type->getMiscClass()::class;

            Entity::withTrashed()->select('entities.id')
                ->where('type_id', $type->id)
                ->where(fn ($query) => $query
                    ->whereNull('child_type')
                    ->orWhere('child_type', '!=', $class)
                    ->orWhereDoesntHaveMorph('child', $class, fn ($child) => $child->withoutGlobalScope(ActiveEntityScope::class)))
                ->chunkById(1000, function ($models): void {
                    foreach ($models as $model) {
                        $this->trace($model);
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

    protected function trace(Entity $entity): void
    {
        $this->traces[] = $entity->id;
        $this->total++;
    }
}

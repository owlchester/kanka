<?php

namespace App\Console\Commands;

use App\Models\Entity;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FixEntityPrivacy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'entities:privacy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix entities with the wrong privacy setting';

    protected $flushThreshold = 500;

    protected $statements = [
        0 => [],
        1 => [],
    ];

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
                ->where('entities.is_private', '<>', DB::raw('f.is_private'))
                ->whereNotNull('f.id')
                ->whereNull('f.deleted_at')
                ->with(Str::camel($type))
                ->chunk(2000, function ($models) use ($type) {
                    $this->info('found ' . count($models) . ' ' . $type);
                    foreach ($models as $model) {
                        $this->fix($model, $type);
                    }
                })
            ;
        }

        $this->flush(0);
        $this->flush(1);


        return 0;
    }

    protected function fix(Entity $entity, string $type)
    {
        // Sanity check
        if (empty($entity->child)) {
            $this->warn('Unexpected situation for entity #' . $entity->id . ' missing child or child deleted?');
            return;
        }
        elseif ($entity->child->name != $entity->name) {
            $this->warn('Unexpected situation for entity #' . $entity->id  . ' name mismatch');
        }
        if ($entity->is_private == $entity->child->is_private) {
            dd('Unexpected situation for entity #' . $entity->id . ' and child ' . $type . ' #'  . $entity->child->id);
        }

        //$this->info('want to fix entity id ' . $entity->id . ' that has private ' . $entity->is_private . ' where child has private ' . $entity->$type->is_private);
        //$this->info('type is ' . $type . ' and child id is ' . $entity->$type->id);
        //dd('?');

        $this->queue($entity->id, $entity->child->is_private);
    }

    protected function queue(int $entity, int $private)
    {
        $this->statements[$private][] = $entity;

        if (count($this->statements[$private]) > $this->flushThreshold) {
            $this->flush($private);
        }
    }

    protected function flush(int $private)
    {
        if (empty($this->statements[$private])) {
            return;
        }

        $ids = implode(', ', $this->statements[$private]);
        dump('updating ' . count($this->statements[$private]) . ' entities to ' . $private);
        DB::statement('UPDATE entities SET is_private = ' . $private . ' WHERE id IN (' . $ids . ')');

        // Reset
        $this->statements[$private] = [];
    }
}

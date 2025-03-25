<?php

namespace App\Console\Commands\Entities;

use App\Models\Entity;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RestoreEntities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'entities:restore';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Restore purged entities';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    protected $ids = [];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $type = 'attribute_template';
        $plural = Str::plural($type);

        $max = Entity::where('type', $type)->doesnthave($type)->count();

        $blocks = 5000;
        $count = 0;

        for ($i = 0; $i <= $max; $i += $blocks) {
            $entities = Entity::select('entity_id')->where('type', $type)
                ->doesnthave($type)
                ->take($blocks)
                ->offset($i)
                ->pluck('entity_id')
                ->toArray();

            Storage::disk('local')->append($type . '.txt', "SELECT * FROM {$plural} WHERE id in (" . implode(',', $entities) . ") and deleted_at is null;\n");
            $count += count($entities);
        }

        $this->info('Done preparing ' . $count . " {$plural}.");
    }
}

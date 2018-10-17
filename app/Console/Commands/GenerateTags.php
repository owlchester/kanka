<?php

namespace App\Console\Commands;

use App\Models\Character;
use App\Models\Entity;
use App\Models\Race;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GenerateTags extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tags';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate tags';

    /**
     * @var int
     */
    protected $cpt = 0;
    protected $cptTags = 0;

    /**
     * @var array
     */
    protected $tags = [];

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
     * @return mixed
     */
    public function handle()
    {
        Entity::whereNotNull('section_id')->chunk(2000, function($entities) {
            foreach ($entities as $entity) {
                /** @var Entity $entity */
                $this->cpt++;

                $entity->tags()->attach($entity->section_id);
            }
        });

        $this->info('Created ' . $this->cpt . ' entity_tags.');
    }
}

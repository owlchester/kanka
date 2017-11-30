<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PopulateEntities extends Migration
{
    /**
     * @var array
     */
    protected $models = [
        'character' => 'App\Models\Character',
        'event' => 'App\Models\Event',
        'family' => 'App\Models\Family',
        'item' => 'App\Models\Item',
        'journal' => 'App\Models\Journal',
        'location' => 'App\Models\Location',
        'note' => 'App\Models\Note',
        'organisation' => 'App\Models\Organisation',
        'quest' => 'App\Models\Quest',
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->models as $type => $class) {
            $realClass = new $class;
            foreach ($realClass->all() as $model) {
                \App\Models\Entity::create([
                    'type' => $type,
                    'entity_id' => $model->id,
                    'name' => $model->name,
                    'is_private' => $model->is_private,
                    'campaign_id' => $model->campaign_id
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DELETE FROM entities');
    }
}

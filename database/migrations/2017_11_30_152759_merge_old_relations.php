<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MergeOldRelations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $relations = \App\Models\CharacterRelation::all();
        foreach ($relations as $relation) {
            \App\Models\Relation::create([
                'campaign_id' => $relation->first->campaign_id,
                'owner_id' => $relation->first->entity->id,
                'target_id' => $relation->second->entity->id,
                'relation' => $relation->relation,
            ]);
        }

        $relations = \App\Models\OrganisationRelation::all();
        foreach ($relations as $relation) {
            \App\Models\Relation::create([
                'campaign_id' => $relation->first->campaign_id,
                'owner_id' => $relation->first->entity->id,
                'target_id' => $relation->second->entity->id,
                'relation' => $relation->relation,
            ]);
        }

        $relations = \App\Models\FamilyRelation::all();
        foreach ($relations as $relation) {
            \App\Models\Relation::create([
                'campaign_id' => $relation->first->campaign_id,
                'owner_id' => $relation->first->entity->id,
                'target_id' => $relation->second->entity->id,
                'relation' => $relation->relation,
            ]);
        }

        $relations = \App\Models\LocationRelation::all();
        foreach ($relations as $relation) {
            \App\Models\Relation::create([
                'campaign_id' => $relation->first->campaign_id,
                'owner_id' => $relation->first->entity->id,
                'target_id' => $relation->second->entity->id,
                'relation' => $relation->relation,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

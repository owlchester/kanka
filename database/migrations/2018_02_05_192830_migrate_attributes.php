<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MigrateAttributes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*$attributes = \App\Models\CharacterAttribute::with('character')->get();

        foreach ($attributes as $attribute) {
            \App\Models\Attribute::create([
                'entity_id' => $attribute->character->entity->id,
                'name' => $attribute->attribute,
                'value' => $attribute->value,
                'is_private' => $attribute->is_private
            ]);
        }

        $attributes = \App\Models\LocationAttribute::with('location')->get();
        foreach ($attributes as $attribute) {
            \App\Models\Attribute::create([
                'entity_id' => $attribute->location->entity->id,
                'name' => $attribute->attribute,
                'value' => $attribute->value,
                'is_private' => $attribute->is_private
            ]);
        }*/
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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdateEntityTypeId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entities', function (Blueprint $table) {
            $table->unsignedInteger('type_id')->nullable()->after('type');
            $table->foreign('type_id')->references('id')->on('entity_types')->onDelete('cascade');
        });

        // The fun part
        $types = [
            1 => 'character',
            2 => 'family',
            3 => 'location',
            4 => 'organisation',
            5 => 'item',
            6 => 'note',
            7 => 'event',
            8 => 'calendar',
            9 => 'race',
            10 => 'quest',
            11 => 'journal',
            12 => 'tag',
            13 => 'dice_roll',
            14 => 'conversation',
            15 => 'attribute_template',
            16 => 'ability',
            17 => 'map',
            18 => 'timeline',
            19 => 'menu_links',
        ];

        foreach ($types as $id => $type) {
            DB::statement("UPDATE entities SET type_id = '" . $id . "' WHERE type = '" . $type . "'");
        }

        Schema::table('entities', function (Blueprint $table) {
            $table->renameColumn('type', 'type_old');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('entities', function (Blueprint $table) {
            $table->dropForeign('entities_type_id_foreign');
            $table->dropColumn('type_id');
        });

        Schema::table('entities', function (Blueprint $table) {
            $table->renameColumn('type_old', 'type');
        });
    }
}

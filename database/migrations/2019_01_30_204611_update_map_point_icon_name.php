<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMapPointIconName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('location_map_points', function(Blueprint $table) {
            $table->string('icon', 20)->change();
        });

        // sprout => sprout-emblem
        // player => character
        // quest => wooden-sign
        DB::table('location_map_points')->where('icon', 'sprout')->update(['icon' => 'sprout-emblem']);
        DB::table('location_map_points')->where('icon', 'character')->update(['icon' => 'player']);
        DB::table('location_map_points')->where('icon', 'quest')->update(['icon' => 'wooden-sign']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('location_map_points')->where('icon', 'sprout-emblem')->update(['icon' => 'sprout']);
        DB::table('location_map_points')->where('icon', 'player')->update(['icon' => 'character']);
        DB::table('location_map_points')->where('icon', 'wooden-sign')->update(['icon' => 'quest']);

        Schema::table('location_map_points', function(Blueprint $table) {
            $table->string('icon', 12)->change();
        });
    }
}

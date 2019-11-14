<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMapPinColours extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("UPDATE location_map_points SET colour = '' where colour = 'none'");
        DB::statement("UPDATE location_map_points SET colour = '#ff0000' where colour = 'red'");
        DB::statement("UPDATE location_map_points SET colour = '#eeff00' where colour = 'yellow'");
        DB::statement("UPDATE location_map_points SET colour = '#0000ff' where colour = 'blue'");
        DB::statement("UPDATE location_map_points SET colour = '#008000' where colour = 'green'");
        DB::statement("UPDATE location_map_points SET colour = '#000000' where colour = 'black'");
        DB::statement("UPDATE location_map_points SET colour = '#ffffff' where colour = 'white'");
        DB::statement("UPDATE location_map_points SET colour = '#808080' where colour = 'grey'");
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

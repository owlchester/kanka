<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMapPointsAddName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('location_map_points', function (Blueprint $table) {
            $table->string('name')->nullable();
            $table->integer('target_id')->unsigned()->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('location_map_points', function (Blueprint $table) {
            $table->integer('target_id')->unsigned()->notNull()->change();
            $table->dropColumn('name');
        });
    }
}

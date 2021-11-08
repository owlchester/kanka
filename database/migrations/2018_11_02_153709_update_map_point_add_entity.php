<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMapPointAddEntity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('location_map_points', function (Blueprint $table) {
            $table->string('shape', 8)->default('circle');
            $table->string('size', 12)->default('standard');

            $table->integer('target_entity_id')->unsigned()->nullable();
            $table->foreign('target_entity_id')->references('id')->on('entities')->onDelete('cascade');
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
            $table->dropColumn('size');
            $table->dropColumn('shape');

            $table->dropForeign('location_map_points_target_entity_id_foreign');
            $table->dropColumn('target_entity_id');
        });
    }
}

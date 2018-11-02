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
            $table->enum('shape', ['circle', 'square', 'triangle'])->defautlValue('circle');
            $table->enum('size', ['standard', 'small', 'large'])->defautlValue('standard');

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

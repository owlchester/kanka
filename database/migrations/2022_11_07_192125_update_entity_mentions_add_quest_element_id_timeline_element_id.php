<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entity_mentions', function (Blueprint $table) {
            $table->unsignedBigInteger('timeline_element_id')->nullable();
            $table->unsignedBigInteger('quest_element_id')->nullable();

            $table->foreign('timeline_element_id')->references('id')->on('timeline_elements')->onDelete('cascade');
            $table->foreign('quest_element_id')->references('id')->on('quest_elements')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('entity_mentions', function (Blueprint $table) {
            $table->dropForeign('quest_element_id');
            $table->dropForeign('timeline_element_id');

            $table->dropColumn('quest_element_id');
            $table->dropColumn('timeline_element_id');
        });
    }
};

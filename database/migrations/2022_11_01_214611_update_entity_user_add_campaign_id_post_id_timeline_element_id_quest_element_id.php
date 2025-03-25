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
        Schema::table('entity_user', function (Blueprint $table) {

            $table->unsignedInteger('campaign_id')->nullable();
            $table->unsignedInteger('post_id')->nullable();
            $table->unsignedBigInteger('timeline_element_id')->nullable();
            $table->unsignedBigInteger('quest_element_id')->nullable();

            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
            $table->foreign('post_id')->references('id')->on('entity_notes')->onDelete('cascade');
            $table->foreign('timeline_element_id')->references('id')->on('timeline_elements')->onDelete('cascade');
            $table->foreign('quest_element_id')->references('id')->on('quest_elements')->onDelete('cascade');

            $table->unsignedInteger('entity_id')->nullable()->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('entity_user', function (Blueprint $table) {
            $table->unsignedInteger('entity_id')->nullable(false)->change();

            $table->dropForeign('campaign_id');
            $table->dropForeign('post_id');
            $table->dropForeign('quest_element_id');
            $table->dropForeign('timeline_element_id');

            $table->dropColumn('campaign_id');
            $table->dropColumn('post_id');
            $table->dropColumn('quest_element_id');
            $table->dropColumn('timeline_element_id');

        });
    }
};

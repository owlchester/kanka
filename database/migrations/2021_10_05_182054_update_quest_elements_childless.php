<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateQuestElementsChildless extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quest_elements', function (Blueprint $table) {
            $table->unsignedInteger('entity_id')->nullable()->change();
            $table->string('name', 100)->nullable();
        });

        Schema::table('community_event_entries', function(Blueprint $table) {
            $table->dropForeign('community_event_entries_created_by_foreign');
            $table
                ->foreign('created_by')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quest_elements', function (Blueprint $table) {
            $table->unsignedInteger('entity_id')->change();
            $table->dropColumn('name');
        });

        Schema::table('community_event_entries', function(Blueprint $table) {
            $table->dropForeign('community_event_entries_created_by_foreign');
            $table
                ->foreign('created_by')
                ->references('id')
                ->on('users')
                ->onUpdate('set null');

        });
    }
}

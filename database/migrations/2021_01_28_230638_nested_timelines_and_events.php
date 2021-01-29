<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NestedTimelinesAndEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('timelines', function (Blueprint $table) {
            $table->unsignedInteger('timeline_id')->nullable();
            $table->unsignedInteger('_lft')->default(0);
            $table->unsignedInteger('_rgt')->default(0);
            $table->index(['_lft', '_rgt']);

            $table->foreign('timeline_id')->references('id')->on('timelines')->onDelete('set null');
        });

        Schema::table('events', function(Blueprint $table) {
            $table->unsignedInteger('event_id')->nullable();
            $table->unsignedInteger('_lft')->default(0);
            $table->unsignedInteger('_rgt')->default(0);
            $table->index(['_lft', '_rgt']);
            $table->foreign('event_id')->references('id')->on('events')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('timelines', function (Blueprint $table) {
            $table->dropForeign('timelines_timeline_id_foreign');
            $table->dropColumn('timeline_id');
            //
        });
        Schema::table('events', function(Blueprint $table) {
            $table->dropForeign('events_event_id_foreign');
            $table->dropColumn('event_id');
        });
    }
}

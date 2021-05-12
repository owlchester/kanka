<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRemindersAddVisibility extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entity_events', function (Blueprint $table) {
            $table->string('visibility', 10)->default('all');
            $table->unsignedInteger('created_by')->nullable();

            $table->foreign('created_by')->on('users')->references('id')->onDelete('set null');
            $table->index(['visibility']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('entity_events', function (Blueprint $table) {
            $table->dropForeign('entity_events_created_by_foreign');
            $table->dropColumn('created_by');
            $table->dropColumn('visibility');
        });
    }
}

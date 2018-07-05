<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Db;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStartEndToCalendarEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entity_events', function (Blueprint $table) {
            $table->smallInteger('length')->default(1);
            $table->string('recurring_until', 12)->nullable();
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
            $table->dropColumn('length');
            $table->dropColumn('recurring_until');
        });
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEntityEventRecurring extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entity_events', function (Blueprint $table) {
            $table->string('recurring_periodicity', 5)->nullable();
        });
        DB::statement("UPDATE entity_events SET recurring_periodicity = 'year' where is_recurring = 1");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('entity_events', function (Blueprint $table) {
            $table->dropColumn('recurring_periodicity');
        });
    }
}

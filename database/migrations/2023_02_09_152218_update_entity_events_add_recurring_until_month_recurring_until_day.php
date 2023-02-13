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
        Schema::table('entity_events', function (Blueprint $table) {
            $table->unsignedMediumInteger('recurring_until_month')->nullable();
            $table->unsignedMediumInteger('recurring_until_day')->nullable();
            $table->index(['recurring_until_month', 'recurring_until_day']);

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
            $table->dropColumn('recurring_until_month');
            $table->dropColumn('recurring_until_day');
        });
    }
};

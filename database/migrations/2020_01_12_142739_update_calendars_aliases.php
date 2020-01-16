<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCalendarsAliases extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('calendars', function (Blueprint $table) {
            $table->text('month_aliases')->nullable();
            $table->text('week_names')->nullable();
            $table->tinyInteger('reset')->nullable();
            $table->boolean('is_incrementing')->default(false);
            $table->index(['is_incrementing']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('calendars', function (Blueprint $table) {
            $table->dropIndex(['is_incrementing']);
            $table->dropColumn('month_aliases');
            $table->dropColumn('week_names');
            $table->dropColumn('reset');
            $table->dropColumn('is_incrementing');
        });
    }
}

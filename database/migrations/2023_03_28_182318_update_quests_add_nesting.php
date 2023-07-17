<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quests', function (Blueprint $table) {
            $table->unsignedInteger('_lft')->default(0);
            $table->unsignedInteger('_rgt')->default(0);
            $table->index(['_lft', '_rgt']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quests', function (Blueprint $table) {
            $table->dropIndex(['lft', 'rgt']);
            $table->dropColumn('lft');
            $table->dropColumn('rgt');
        });
    }
};

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPrivateStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tables = ['characters', 'families', 'items', 'locations', 'notes', 'organisations'];
        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $t) {
                $t->boolean('is_private')->default(false);
                $t->index(['is_private']);
            });
        }
        // Default hidden
        $tables = ['journals'];
        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $t) {
                $t->boolean('is_private')->default(true);
                $t->index(['is_private']);
            });
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tables = ['characters', 'families', 'items', 'locations', 'notes', 'organisations', 'journals'];
        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $t) {
                $t->dropColumn('is_private');
            });
        }
    }
}

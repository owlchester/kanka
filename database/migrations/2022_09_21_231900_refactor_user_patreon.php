<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RefactorUserPatreon extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('patreon_pledge', 10)->nullable()->change();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('patreon_pledge', 'pledge');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('pledge', 10)->nullable(false)->change();
            $table->renameColumn('pledge', 'patreon_pledge');
        });
    }
}

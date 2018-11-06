<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrganisationParentOrg extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organisations', function (Blueprint $table) {
            $table->unsignedInteger('organisation_id')->nullable();
            $table->unsignedInteger('_lft')->default(0);
            $table->unsignedInteger('_rgt')->default(0);
            $table->index(['_lft', '_rgt', 'organisation_id']);

            $table->foreign('organisation_id')->references('id')->on('organisations')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->dropIndex(['lft', 'rgt', 'organisation_id']);
            $table->dropColumn('lft');
            $table->dropColumn('rgt');
            $table->dropColumn('organisation_id');
        });
    }
}

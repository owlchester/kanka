<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMembersAddParent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organisation_member', function (Blueprint $table) {
            $table->unsignedInteger('parent_id')->nullable();

            $table->foreign('parent_id')->references('id')->on('organisation_member')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('organisation_member', function (Blueprint $table) {
            $table->dropColumn('parent_id');
        });
    }
}

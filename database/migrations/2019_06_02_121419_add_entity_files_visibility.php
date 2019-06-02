<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEntityFilesVisibility extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entity_files', function (Blueprint $table) {
            $table->string('visibility')->default('all');
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
        Schema::table('entity_files', function (Blueprint $table) {
            $table->dropColumn('visibility');
        });
    }
}

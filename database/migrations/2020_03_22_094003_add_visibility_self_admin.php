<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVisibilitySelfAdmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entity_notes', function (Blueprint $table) {
            $table->enum('visibility', ['all', 'admin', 'self', 'admin-self'])->default('all')->change();
        });

        Schema::table('relations', function (Blueprint $table) {
            $table->string('visibility', 10)->default('all')->change();
        });

        Schema::table('entity_files', function (Blueprint $table) {
            $table->string('visibility', 10)->default('all')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('entity_notes', function (Blueprint $table) {
            $table->enum('visibility', ['all', 'admin', 'self'])->default('all')->change();
        });

        Schema::table('relations', function (Blueprint $table) {
            $table->string('visibility', 191)->default('all')->change();
        });

        Schema::table('entity_files', function (Blueprint $table) {
            $table->string('visibility', 191)->default('all')->change();
        });
    }
}

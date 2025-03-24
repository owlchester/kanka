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
        Schema::table('entity_note_permissions', function (Blueprint $table) {
            $table->renameColumn('entity_note_id', 'post_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('entity_note_permissions', function (Blueprint $table) {
            $table->renameColumn('post_id', 'entity_note_id');
        });
    }
};

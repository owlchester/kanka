<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateEntityNotesPinned extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entity_notes', function (Blueprint $table) {
            $table->boolean('is_pinned')->default(false);
            $table->unsignedTinyInteger('position')->nullable();

            $table->index(['is_pinned', 'position']);
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
            $table->dropColumn('is_pinned');
            $table->dropColumn('position');
        });
    }
}

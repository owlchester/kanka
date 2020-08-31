<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNoteNesting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notes', function (Blueprint $table) {
            $table->unsignedInteger('note_id')->nullable();
            $table->unsignedInteger('_lft')->default(0);
            $table->unsignedInteger('_rgt')->default(0);
            $table->index(['_lft', '_rgt', 'note_id']);

            $table->foreign('note_id')->references('id')->on('notes')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notes', function (Blueprint $table) {
            $table->dropIndex(['lft', 'rgt', 'note_id']);
            $table->dropColumn('lft');
            $table->dropColumn('rgt');
            $table->dropColumn('note_id');
        });
    }
}

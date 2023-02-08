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
        Schema::table('entity_logs', function (Blueprint $table) {
   
            $table->integer('entity_note_id')->unsigned()->nullable();
            $table->foreign('entity_note_id')->references('id')->on('entity_notes')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('entity_logs', function (Blueprint $table) {
            $table->dropForeign(['entity_note_id']);
            $table->dropColumn('entity_note_id');        
        });
    }
};

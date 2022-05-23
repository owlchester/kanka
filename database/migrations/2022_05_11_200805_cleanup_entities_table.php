<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CleanupEntitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entities', function (Blueprint $table) {
            $table->dropColumn('type');
            //$table->dropForeign('entities_section_id_foreign');
            //$table->dropColumn('section_id');
            $table->index(['entity_id'], 'idx_entity_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('entities', function (Blueprint $table) {
            $table->dropIndex('idx_entity_id');
        });
    }
}

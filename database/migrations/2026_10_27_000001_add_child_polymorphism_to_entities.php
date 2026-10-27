<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('entities', function (Blueprint $table) {
            $table->string('child_type', 191)->nullable();
            $table->index(['child_type', 'entity_id'], 'entities_child_type_entity_id_index');
        });
    }

    public function down(): void
    {
        Schema::table('entities', function (Blueprint $table) {
            $table->dropIndex('entities_child_type_entity_id_index');
            $table->dropColumn('child_type');
        });
    }
};

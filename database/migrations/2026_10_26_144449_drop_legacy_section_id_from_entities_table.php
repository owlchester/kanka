<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('entities', 'section_id')) {
            return;
        }

        foreach (Schema::getForeignKeys('entities') as $foreignKey) {
            if (in_array('section_id', $foreignKey['columns'], true)) {
                Schema::table('entities', function (Blueprint $table) use ($foreignKey) {
                    $table->dropForeign(
                        Schema::getConnection()->getDriverName() === 'sqlite'
                            ? $foreignKey['columns']
                            : $foreignKey['name']
                    );
                });
            }
        }

        if (Schema::hasIndex('entities', 'entities_section_id_foreign')) {
            Schema::table('entities', function (Blueprint $table) {
                $table->dropIndex('entities_section_id_foreign');
            });
        }

        Schema::table('entities', function (Blueprint $table) {
            $table->dropColumn('section_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Legacy column data cannot be restored.
    }
};

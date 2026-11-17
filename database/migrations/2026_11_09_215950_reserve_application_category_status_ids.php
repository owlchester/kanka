<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            if (! DB::table('sqlite_sequence')->where('name', 'category_statuses')->exists()) {
                DB::table('sqlite_sequence')->insert(['name' => 'category_statuses', 'seq' => 999]);
            } else {
                DB::table('sqlite_sequence')->where('name', 'category_statuses')->where('seq', '<', 999)->update(['seq' => 999]);
            }

            return;
        }

        $table = DB::selectOne('SELECT AUTO_INCREMENT AS next_id FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ?', ['category_statuses']);
        if (DB::connection()->pretending() || (int) $table->next_id < 1000) {
            DB::statement('ALTER TABLE category_statuses AUTO_INCREMENT = 1000');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Allocated identifiers must never be reused by a rollback.
    }
};

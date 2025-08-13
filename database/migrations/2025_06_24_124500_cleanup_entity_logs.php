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
        Schema::table('entity_logs', function (Blueprint $table) {
            if (Schema::getConnection()->getDriverName() !== 'sqlite') {
                $table->dropForeign('entity_logs_entity_id_foreign');
                $table->dropColumn('entity_id');
                $table->dropForeign('entity_logs_post_id_foreign');
                $table->dropColumn('post_id');
            } else {
                $table->dropConstrainedForeignId('entity_id');
                $table->dropConstrainedForeignId('post_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('entity_logs', function (Blueprint $table) {
            //
        });
    }
};

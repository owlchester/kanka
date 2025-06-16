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
        if (! config('logging.enabled')) {
            return;
        }

        Schema::connection('logs')->table('api_logs', function (Blueprint $table) {
            $table->string('response', 3)->nullable();
            $table->decimal('duration', 8, 3)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! config('logging.enabled')) {
            return;
        }

        Schema::connection('logs')->table('api_logs', function (Blueprint $table) {
            $table->dropColumn('response');
            $table->dropColumn('duration');
        });
    }
};

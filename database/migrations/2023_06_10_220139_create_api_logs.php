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
        if (Schema::connection('logs')->hasTable('api_logs')) {
            return;
        }
        Schema::connection('logs')->create('api_logs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('campaign_id')->nullable();
            $table->text('uri')->nullable();
            $table->json('params')->nullable();
            $table->index(['created_at']);
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
        Schema::connection('logs')->dropIfExists('api_logs');
    }
};

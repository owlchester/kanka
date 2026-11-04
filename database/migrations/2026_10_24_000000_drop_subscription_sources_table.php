<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('subscription_sources');
    }

    public function down(): void
    {
        // This recreates the schema only; dropped historical payment records cannot be restored.
        Schema::create('subscription_sources', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('charge_id', 45)->nullable();
            $table->string('source_id', 45);
            $table->string('tier', 12);
            $table->string('period', 10);
            $table->string('method', 10);
            $table->unsignedInteger('user_id');
            $table->string('status', 12);
            $table->timestamps();

            $table->index(['source_id', 'charge_id', 'status']);
        });
    }
};

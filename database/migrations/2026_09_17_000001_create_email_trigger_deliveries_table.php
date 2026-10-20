<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_trigger_deliveries', function (Blueprint $table): void {
            $table->id();
            $table->unsignedInteger('user_id');
            // Email triggers are managed by the separate marketing application.
            $table->unsignedBigInteger('email_trigger_id')->nullable();
            $table->string('stage', 20);
            $table->string('trigger', 20);
            $table->string('audience', 20);
            $table->string('template');
            $table->string('status', 20)->default('sending');
            $table->unsignedTinyInteger('attempts')->default(1);
            $table->string('provider_message_id')->nullable();
            $table->text('error')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->unique(['user_id', 'stage']);
            $table->index(['stage', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_trigger_deliveries');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('legacy_image_migrations', function (Blueprint $table) {
            $table->id();
            $table->char('source_hash', 64)->unique();
            $table->text('source_path');
            $table->string('destination_path')->unique();
            $table->unsignedInteger('campaign_id');
            $table->unsignedInteger('entity_id');
            $table->unsignedBigInteger('size')->nullable();
            $table->string('status', 20)->default('pending')->index();
            $table->text('error')->nullable();
            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('legacy_image_migrations');
    }
};

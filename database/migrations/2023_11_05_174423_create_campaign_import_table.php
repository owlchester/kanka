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
        Schema::create('campaign_imports', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedInteger('campaign_id');
            $table->unsignedInteger('user_id')->nullable();

            $table->text('config')->nullable();
            $table->unsignedTinyInteger('status_id')->default(1);

            $table->foreign('campaign_id')->references('id')->on('campaigns')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaign_import');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('entity_claims', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('entity_id');
            $table->unsignedInteger('user_id');
            $table->dateTime('claimed_at');
            $table->dateTime('unclaimed_at')->nullable();

            $table->foreign('entity_id')->references('id')->on('entities')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entity_claims');
    }
};

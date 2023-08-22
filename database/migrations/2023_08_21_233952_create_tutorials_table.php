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
        Schema::create('user_tutorials', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->string('code', 45);
            $table->timestamps();

            $table->unique(['user_id', 'code']);

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_tutorials');
    }
};

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
        Schema::dropIfExists('referral_events');
        Schema::create('referral_events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('referred_by')->nullable();
            $table->tinyInteger('type')->default(1);
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('referred_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referral_events');
    }
};

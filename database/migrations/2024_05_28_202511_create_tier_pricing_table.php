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
        Schema::create('tier_prices', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('tier_id');
            $table->string('currency', 3);
            $table->double('cost', 10, 3)->unsigned();
            $table->unsignedTinyInteger('period')->default(1);
            $table->string('stripe_id', 191);

            $table->index(['currency', 'period']);

            $table->foreign('tier_id')->references('id')->on('tiers')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tier_prices');
    }
};

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
        if (!Schema::hasTable('subscription_cancellations')) {
            return;
        }
        Schema::table('subscription_cancellations', function (Blueprint $table) {
            $table->string('secondary')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscription_cancellations', function (Blueprint $table) {
            $table->dropColumn('secondary');
        });
    }
};

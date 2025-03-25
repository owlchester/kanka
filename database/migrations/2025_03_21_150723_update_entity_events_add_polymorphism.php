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
        Schema::table('reminders', function (Blueprint $table) {
            $table->unsignedBigInteger('remindable_id')->nullable();
            $table->string('remindable_type')->nullable();
            $table->index(['remindable_id', 'remindable_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reminders', function (Blueprint $table) {
            $table->dropIndex(['remindable_id', 'remindable_type']);
            $table->dropColumn('remindable_type');
            $table->dropColumn('remindable_id');
        });
    }
};

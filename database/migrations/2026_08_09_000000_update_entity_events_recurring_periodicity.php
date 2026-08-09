<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::getConnection()->getDriverName() === 'sqlite') {
            return;
        }

        Schema::table('reminders', function (Blueprint $table): void {
            $table->string('recurring_periodicity', 32)->nullable()->change();
        });
    }

    public function down(): void
    {
        if (Schema::getConnection()->getDriverName() === 'sqlite') {
            return;
        }

        Schema::table('reminders', function (Blueprint $table): void {
            $table->string('recurring_periodicity', 5)->nullable()->change();
        });
    }
};

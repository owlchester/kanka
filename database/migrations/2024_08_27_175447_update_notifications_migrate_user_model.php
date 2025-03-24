<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Illuminate\Support\Facades\DB::table('notifications')
            ->where('notifiable_type', 'App\\User')
            ->update(['notifiable_type' => 'App\\Models\\User']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {}
};

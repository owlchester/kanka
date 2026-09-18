<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->index('created_at', 'users_onboarding_created_at_index');
        });

        Schema::table('entities', function (Blueprint $table): void {
            $table->index(
                ['created_by', 'source', 'deleted_at'],
                'entities_onboarding_eligibility_index',
            );
        });
    }

    public function down(): void
    {
        Schema::table('entities', function (Blueprint $table): void {
            $table->dropIndex('entities_onboarding_eligibility_index');
        });

        Schema::table('users', function (Blueprint $table): void {
            $table->dropIndex('users_onboarding_created_at_index');
        });
    }
};

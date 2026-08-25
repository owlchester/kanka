<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('entities', function (Blueprint $table) {
            $table->boolean('is_claimable')
                ->default(0)
                ->after('is_template');
            $table->index('is_claimable');
        });
    }

    public function down(): void
    {
        Schema::table('entities', function (Blueprint $table) {
            $table->dropIndex(['is_claimable']);
            $table->dropColumn('is_claimable');
        });
    }
};

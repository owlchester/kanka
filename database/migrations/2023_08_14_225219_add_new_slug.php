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
        Schema::table('campaigns', function (Blueprint $table) {
            $table->string('slug', 45)->nullable()->unique()->after('name');
        });
        Illuminate\Support\Facades\DB::statement('UPDATE campaigns SET slug = id');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {}
};

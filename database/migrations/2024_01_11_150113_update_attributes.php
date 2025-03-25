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
        Schema::table('attributes', function (Blueprint $table) {
            $table->string('api_key', 20)->nullable()->change();
            // $table->tinyInteger('is_hidden')->default(0)->change();
        });

        Illuminate\Support\Facades\DB::raw('ALTER TABLE `attributes` MODIFY `is_hidden` tinyint(1) DEFAULT 0 NOT NULL;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attributes', function (Blueprint $table) {});
    }
};

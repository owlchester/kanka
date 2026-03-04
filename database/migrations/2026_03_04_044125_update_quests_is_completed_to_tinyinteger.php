<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('quests')->where('is_completed', 1)->update(['is_completed' => 2]);

        Schema::table('quests', function (Blueprint $table) {
            $table->tinyInteger('is_completed')->unsigned()->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('quests')->where('is_completed', 2)->update(['is_completed' => 1]);
        DB::table('quests')->where('is_completed', '>', 1)->update(['is_completed' => 0]);

        Schema::table('quests', function (Blueprint $table) {
            $table->boolean('is_completed')->default(false)->change();
        });
    }
};

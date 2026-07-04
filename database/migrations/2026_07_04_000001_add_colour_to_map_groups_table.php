<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('map_groups', function (Blueprint $table) {
            $table->string('colour', 7)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('map_groups', function (Blueprint $table) {
            $table->dropColumn('colour');
        });
    }
};

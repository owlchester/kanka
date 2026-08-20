<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('entities', function (Blueprint $table) {
            $table->integer('entity_id')->unsigned()->nullable()->change();
        });
    }

    public function down(): void
    {
        if (DB::table('entities')->whereNull('entity_id')->exists()) {
            throw new RuntimeException('Cannot make entities.entity_id non-nullable while unlinked entities exist.');
        }

        Schema::table('entities', function (Blueprint $table) {
            $table->integer('entity_id')->unsigned()->nullable(false)->change();
        });
    }
};

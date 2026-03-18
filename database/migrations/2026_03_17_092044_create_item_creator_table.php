<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('item_creator', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('item_id');
            $table->unsignedInteger('creator_id');
            $table->timestamps();

            $table->foreign('item_id')->references('id')->on('items')->cascadeOnDelete();
            $table->foreign('creator_id')->references('id')->on('entities')->cascadeOnDelete();
        });

        // Migrate existing creator_id data to the pivot table
        DB::statement('
            INSERT INTO item_creator (item_id, creator_id, created_at, updated_at)
            SELECT id, creator_id, NOW(), NOW()
            FROM items
            WHERE creator_id IS NOT NULL AND deleted_at IS NULL
        ');

        Schema::table('items', function (Blueprint $table) {
            $table->dropForeign(['creator_id']);
            $table->dropColumn('creator_id');
        });
    }

    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->unsignedInteger('creator_id')->nullable();
            $table->foreign('creator_id')->references('id')->on('entities')->cascadeOnDelete();
        });

        // Migrate first creator back to the items table
        DB::statement('
            UPDATE items
            INNER JOIN (
                SELECT item_id, MIN(creator_id) as creator_id
                FROM item_creator
                GROUP BY item_id
            ) ic ON items.id = ic.item_id
            SET items.creator_id = ic.creator_id
        ');

        Schema::dropIfExists('item_creator');
    }
};

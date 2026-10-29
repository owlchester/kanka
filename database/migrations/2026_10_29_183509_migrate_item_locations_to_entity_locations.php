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
        $itemTypeId = DB::table('entity_types')->where('code', 'item')->value('id');
        $items = DB::table('items')
            ->join('entities', function ($join) use ($itemTypeId) {
                $join->on('entities.entity_id', '=', 'items.id')->where('entities.type_id', $itemTypeId);
            })
            ->join('locations', 'locations.id', '=', 'items.location_id')
            ->whereNotNull('items.location_id')
            ->select('entities.id as entity_id', 'items.location_id', 'entities.created_by')
            ->get();

        foreach ($items as $item) {
            DB::table('entity_locations')->insert([
                'entity_id' => $item->entity_id,
                'location_id' => $item->location_id,
                'created_by' => $item->created_by,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        Schema::table('items', function (Blueprint $table) {
            $table->dropForeign(['location_id']);
            $table->dropColumn('location_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->unsignedInteger('location_id')->nullable();
            $table->foreign('location_id')->references('id')->on('locations')->nullOnDelete();
        });
    }
};

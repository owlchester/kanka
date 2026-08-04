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
        // Clean up any partial inserts from a previous failed run
        DB::table('entity_locations')
            ->whereIn('entity_id', function ($query) {
                $query->select('entities.id')
                    ->from('entities')
                    ->where('entities.type_id', '=', config('entities.ids.family'));
            })
            ->delete();

        $families = DB::table('families')
            ->join('entities', function ($join) {
                $join->on('entities.entity_id', '=', 'families.id')
                    ->where('entities.type_id', '=', config('entities.ids.family'));
            })
            ->join('locations', 'locations.id', '=', 'families.location_id')
            ->whereNotNull('families.location_id')
            ->select('entities.id as entity_id', 'families.location_id', 'entities.created_by')
            ->get();

        foreach ($families as $family) {
            DB::table('entity_locations')->insert([
                'entity_id' => $family->entity_id,
                'location_id' => $family->location_id,
                'created_by' => $family->created_by,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        Schema::table('families', function (Blueprint $table) {
            $table->dropForeign(['location_id']);
            $table->dropColumn('location_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('families', function (Blueprint $table) {
            $table->integer('location_id')->unsigned()->nullable();
            $table->foreign('location_id')->references('id')->on('locations')->nullOnDelete();
        });
    }
};

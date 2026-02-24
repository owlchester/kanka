<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Migrate organisation, race, and creature locations from their individual
     * pivot tables to the shared entity_locations table.
     */
    public function up(): void
    {
        if (! Schema::hasTable('race_location')) {
            return;
        }
        // Migrate race locations
        $races = DB::table('races')
            ->join('entities', function ($join) {
                $join->on('entities.entity_id', '=', 'races.id')
                    ->where('entities.type_id', '=', config('entities.ids.race'));
            })
            ->join('race_location', 'race_location.race_id', '=', 'races.id')
            ->select('entities.id as entity_id', 'race_location.location_id', 'entities.created_by')
            ->get();

        foreach ($races as $race) {
            DB::table('entity_locations')->insert([
                'entity_id' => $race->entity_id,
                'location_id' => $race->location_id,
                'created_by' => $race->created_by,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Note: This is a data migration. The down() method doesn't restore data
        // from entity_locations back to the old pivot tables because that data
        // is still preserved in the original tables.
    }
};

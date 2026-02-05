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
        // Migrate organisation locations
        $organisations = DB::table('organisations')
            ->join('entities', function ($join) {
                $join->on('entities.entity_id', '=', 'organisations.id')
                    ->where('entities.type_id', '=', config('entities.ids.organisation'));
            })
            ->join('organisation_location', 'organisation_location.organisation_id', '=', 'organisations.id')
            ->select('entities.id as entity_id', 'organisation_location.location_id', 'entities.created_by')
            ->get();

        foreach ($organisations as $org) {
            DB::table('entity_locations')->insert([
                'entity_id' => $org->entity_id,
                'location_id' => $org->location_id,
                'created_by' => $org->created_by,
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

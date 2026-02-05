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
            // Check for existing entry to avoid duplicates
            $exists = DB::table('entity_locations')
                ->where('entity_id', $org->entity_id)
                ->where('location_id', $org->location_id)
                ->exists();

            if (! $exists) {
                DB::table('entity_locations')->insert([
                    'entity_id' => $org->entity_id,
                    'location_id' => $org->location_id,
                    'created_by' => $org->created_by,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
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
            $exists = DB::table('entity_locations')
                ->where('entity_id', $race->entity_id)
                ->where('location_id', $race->location_id)
                ->exists();

            if (! $exists) {
                DB::table('entity_locations')->insert([
                    'entity_id' => $race->entity_id,
                    'location_id' => $race->location_id,
                    'created_by' => $race->created_by,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Migrate creature locations
        $creatures = DB::table('creatures')
            ->join('entities', function ($join) {
                $join->on('entities.entity_id', '=', 'creatures.id')
                    ->where('entities.type_id', '=', config('entities.ids.creature'));
            })
            ->join('creature_location', 'creature_location.creature_id', '=', 'creatures.id')
            ->select('entities.id as entity_id', 'creature_location.location_id', 'entities.created_by')
            ->get();

        foreach ($creatures as $creature) {
            $exists = DB::table('entity_locations')
                ->where('entity_id', $creature->entity_id)
                ->where('location_id', $creature->location_id)
                ->exists();

            if (! $exists) {
                DB::table('entity_locations')->insert([
                    'entity_id' => $creature->entity_id,
                    'location_id' => $creature->location_id,
                    'created_by' => $creature->created_by,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Note: Old pivot tables are intentionally NOT dropped for safety.
        // They can be removed in a later cleanup migration after verification.
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

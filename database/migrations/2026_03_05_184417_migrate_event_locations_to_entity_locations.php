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
                    ->where('entities.type_id', '=', config('entities.ids.event'));
            })
            ->delete();

        $events = DB::table('events')
            ->join('entities', function ($join) {
                $join->on('entities.entity_id', '=', 'events.id')
                    ->where('entities.type_id', '=', config('entities.ids.event'));
            })
            ->join('locations', 'locations.id', '=', 'events.location_id')
            ->whereNotNull('events.location_id')
            ->select('entities.id as entity_id', 'events.location_id', 'entities.created_by')
            ->get();

        foreach ($events as $event) {
            DB::table('entity_locations')->insert([
                'entity_id' => $event->entity_id,
                'location_id' => $event->location_id,
                'created_by' => $event->created_by,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('location_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->integer('location_id')->unsigned()->nullable();
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $characters = DB::table('characters')
            ->join('entities', function ($join) {
                $join->on('entities.entity_id', '=', 'characters.id')
                    ->where('entities.type_id', '=', config('entities.ids.character'));
            })
            ->whereNotNull('characters.location_id')
            ->select('entities.id as entity_id', 'characters.location_id', 'entities.created_by')
            ->get();

        foreach ($characters as $character) {
            DB::table('entity_locations')->insert([
                'entity_id' => $character->entity_id,
                'location_id' => $character->location_id,
                'created_by' => $character->created_by,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        Schema::table('characters', function (Blueprint $table) {
            $table->dropForeign(['location_id']);
            $table->dropColumn('location_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('characters', function (Blueprint $table) {
            $table->integer('location_id')->unsigned()->nullable();
            $table->foreign('location_id')->references('id')->on('locations')->nullOnDelete();
        });
    }
};

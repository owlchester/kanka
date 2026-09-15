<?php

use App\Models\EntityType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $journalTypeId = EntityType::default()->where('code', 'journal')->value('id');
        // Clean up pivot rows created by the old, unused Journal bulk action.
        DB::table('entity_locations')
            ->whereIn('entity_id', function ($query) use ($journalTypeId) {
                $query->select('entities.id')
                    ->from('entities')
                    ->where('entities.type_id', '=', $journalTypeId);
            })
            ->delete();

        $journals = DB::table('journals')
            ->join('entities', function ($join) use ($journalTypeId) {
                $join->on('entities.entity_id', '=', 'journals.id')
                    ->where('entities.type_id', '=', $journalTypeId);
            })
            ->join('locations', 'locations.id', '=', 'journals.location_id')
            ->whereNotNull('journals.location_id')
            ->select('entities.id as entity_id', 'journals.location_id', 'entities.created_by')
            ->get();

        foreach ($journals as $journal) {
            DB::table('entity_locations')->insert([
                'entity_id' => $journal->entity_id,
                'location_id' => $journal->location_id,
                'created_by' => $journal->created_by,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        Schema::table('journals', function (Blueprint $table) {
            $table->dropForeign(['location_id']);
            $table->dropColumn('location_id');
        });
    }

    public function down(): void
    {
        Schema::table('journals', function (Blueprint $table) {
            $table->integer('location_id')->unsigned()->nullable();
            $table->foreign('location_id')->references('id')->on('locations')->nullOnDelete();
        });
    }
};

<?php

use App\Models\EntityType;
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
        /** @var EntityType $entityType */
        $exclude = ['attribute_template', 'bookmark', 'dice_roll', 'conversation'];
        foreach (EntityType::default()->whereNotIn('code', $exclude)->get() as $entityType) {
            DB::statement('UPDATE entities JOIN ' . $entityType->pluralCode() . ' as s ON entities.entity_id = s.id SET entities.entry = s.entry, entities.type = s.type WHERE entities.type_id = ' . $entityType->id);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('entities', function (Blueprint $table) {});
    }
};

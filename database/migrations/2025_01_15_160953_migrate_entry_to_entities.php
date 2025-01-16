<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        /** @var App\Models\EntityType $entityType */
        $exclude = [
            config('entities.ids.attribute_template'),
            config('entities.ids.bookmark'),
            config('entities.ids.dice_roll'),
            config('entities.ids.conversation'),
        ];
        foreach (App\Models\EntityType::default()->exclude($exclude)->get() as $entityType) {
            DB::statement("UPDATE entities JOIN " . $entityType->pluralCode() . " as s ON entities.entity_id = s.id SET entities.entry = s.entry, entities.type = s.type WHERE entities.type_id = " . $entityType->id);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('entities', function (Blueprint $table) {

        });
    }
};

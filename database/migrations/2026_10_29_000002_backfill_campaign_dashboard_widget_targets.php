<?php

use App\Models\Entity;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('campaign_dashboard_widgets')
            ->where('widget', 'header')
            ->whereNotNull('entity_id')
            ->update([
                'target_type' => Entity::class,
                'target_id' => DB::raw('entity_id'),
                'entity_id' => null,
            ]);
    }

    public function down(): void
    {
        DB::table('campaign_dashboard_widgets')
            ->where('widget', 'header')
            ->where('target_type', Entity::class)
            ->whereNull('entity_id')
            ->update([
                'entity_id' => DB::raw('target_id'),
                'target_type' => null,
                'target_id' => null,
            ]);
    }
};

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
        foreach (\App\Models\EntityType::default()->get() as $entityType) {
            DB::statement("UPDATE campaign_dashboard_widgets
SET entity_type_id = " . $entityType->id . "
WHERE config like '%\"entity\":\"" . $entityType->code . "\"%'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};

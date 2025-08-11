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
        $tables = [
            'characters' => ['family_id'],
            'locations' => ['is_map_private'],
            'organisations' => ['location_id'],
            'quests' => ['calendar_id', 'calendar_year', 'calendar_month', 'calendar_day'],
            'journals' => ['calendar_id', 'calendar_year', 'calendar_month', 'calendar_day'],
        ];
        foreach ($tables as $tablename => $extra) {
            Schema::table($tablename, function (Blueprint $table) use ($extra, $tablename) {
                if (Schema::getConnection()->getDriverName() !== 'sqlite') {
                    foreach ($extra as $column) {
                        if (\Illuminate\Support\Str::endsWith($column, '_id')) {
                            $table->dropForeign($tablename . '_' . $column . '_foreign');
                        }
                        $table->dropColumn($column);
                    }
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

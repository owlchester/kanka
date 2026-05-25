<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Patched for fresh installs: columns/indexes may not exist.
     */
    public function up(): void
    {
        $tables = [
            'characters', 'families', 'locations', 'organisations',
            'items', 'notes', 'events', 'calendars', 'races', 'quests',
            'journals', 'tags', 'abilities', 'maps', 'timelines', 'creatures',
        ];

        foreach ($tables as $tablename) {
            if (!Schema::hasTable($tablename)) {
                continue;
            }

            // Drop indexes (may not exist on fresh installs)
            try {
                if (!in_array($tablename, ['families', 'items', 'events', 'calendars', 'races', 'quests', 'journals', 'tags', 'creatures'])) {
                    Schema::table($tablename, function (Blueprint $table) {
                        $table->dropIndex(['name_type']);
                    });
                } elseif (in_array($tablename, ['items', 'races', 'creatures'])) {
                    Schema::table($tablename, function (Blueprint $table) {
                        $table->dropIndex(['name_type_is_private']);
                    });
                } elseif ($tablename === 'events') {
                    Schema::table($tablename, function (Blueprint $table) {
                        $table->dropIndex(['name_type_date_is_private']);
                    });
                } elseif ($tablename === 'journals') {
                    Schema::table($tablename, function (Blueprint $table) {
                        $table->dropIndex(['name_type_date']);
                    });
                } elseif ($tablename === 'tags') {
                    Schema::table($tablename, function (Blueprint $table) {
                        $table->dropIndex(['name_type_is_private_is_hidden_is_auto_applied']);
                    });
                }
            } catch (\Exception $e) {
                // Index doesn't exist on fresh install — safe to ignore
            }

            // Drop columns (may not exist on fresh installs)
            Schema::table($tablename, function (Blueprint $table) use ($tablename) {
                if (Schema::hasColumn($tablename, 'type')) {
                    $table->dropColumn('type');
                }
                if (Schema::hasColumn($tablename, 'entry')) {
                    $table->dropColumn('entry');
                }
            });
        }
    }

    public function down(): void
    {
        //
    }
};

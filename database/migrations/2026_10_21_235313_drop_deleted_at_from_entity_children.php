<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $tables = [
        'abilities',
        'attribute_templates',
        'calendars',
        'characters',
        'conversations',
        'creatures',
        'dice_rolls',
        'events',
        'families',
        'items',
        'journals',
        'locations',
        'maps',
        'notes',
        'organisations',
        'quests',
        'races',
        'tags',
        'timelines',
        'whiteboards',
    ];

    public function up(): void
    {
        foreach ($this->tables as $name) {
            Schema::table($name, function (Blueprint $table) use ($name) {
                if (Schema::hasIndex($name, $name . '_deleted_at_index')) {
                    $table->dropIndex(['deleted_at']);
                }
                if (Schema::hasColumn($name, 'deleted_at')) {
                    $table->dropSoftDeletes();
                }
            });
        }
    }

    public function down(): void
    {
        // Restore the schema only; entity deletion state remains authoritative.
        foreach ($this->tables as $name) {
            Schema::table($name, function (Blueprint $table) {
                $table->softDeletes();
                $table->index('deleted_at');
            });
        }
    }
};

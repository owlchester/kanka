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
            Schema::table($name, function (Blueprint $table) {
                $table->dropTimestamps();
            });
        }
    }

    public function down(): void
    {
        // Recreate the schema only; the original child timestamps cannot be recovered.
        foreach ($this->tables as $name) {
            Schema::table($name, function (Blueprint $table) {
                $table->timestamps();
            });
        }
    }
};

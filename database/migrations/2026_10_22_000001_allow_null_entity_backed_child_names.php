<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $tables = [
        'abilities' => 'ability',
        'attribute_templates' => 'attribute_template',
        'calendars' => 'calendar',
        'characters' => 'character',
        'conversations' => 'conversation',
        'creatures' => 'creature',
        'dice_rolls' => 'dice_roll',
        'events' => 'event',
        'families' => 'family',
        'items' => 'item',
        'journals' => 'journal',
        'locations' => 'location',
        'maps' => 'map',
        'notes' => 'note',
        'organisations' => 'organisation',
        'quests' => 'quest',
        'races' => 'race',
        'tags' => 'tag',
        'timelines' => 'timeline',
        'whiteboards' => 'whiteboard',
    ];

    public function up(): void
    {
        foreach ($this->tables as $tableName => $entityType) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                $table->string('name', $this->nameLength($tableName))->nullable()->change();
            });
        }
    }

    public function down(): void
    {
        foreach ($this->tables as $tableName => $entityType) {
            DB::table($tableName)->whereNull('name')->orderBy('id')->chunkById(500, function ($children) use ($tableName, $entityType) {
                foreach ($children as $child) {
                    $name = DB::table('entities')
                        ->where('entity_id', $child->id)
                        ->where('type_id', config('entities.ids.' . $entityType))
                        ->value('name');
                    if ($name === null) {
                        throw new RuntimeException("Cannot restore {$tableName}.name for child {$child->id}: entity name is missing.");
                    }
                    DB::table($tableName)->where('id', $child->id)->update(['name' => $name]);
                }
            });

            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                $table->string('name', $this->nameLength($tableName))->nullable(false)->change();
            });
        }
    }

    private function nameLength(string $table): int
    {
        return in_array($table, ['conversations', 'creatures', 'dice_rolls', 'races', 'whiteboards'], true) ? 191 : 255;
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public $withinTransaction = false;

    public function up(): void
    {
        $classes = [
            'ability' => 'App\Models\Ability',
            'attribute_template' => 'App\Models\AttributeTemplate',
            'calendar' => 'App\Models\Calendar',
            'character' => 'App\Models\Character',
            'conversation' => 'App\Models\Conversation',
            'creature' => 'App\Models\Creature',
            'dice_roll' => 'App\Models\DiceRoll',
            'event' => 'App\Models\Event',
            'family' => 'App\Models\Family',
            'item' => 'App\Models\Item',
            'journal' => 'App\Models\Journal',
            'location' => 'App\Models\Location',
            'map' => 'App\Models\Map',
            'note' => 'App\Models\Note',
            'organisation' => 'App\Models\Organisation',
            'quest' => 'App\Models\Quest',
            'race' => 'App\Models\Race',
            'tag' => 'App\Models\Tag',
            'timeline' => 'App\Models\Timeline',
            'whiteboard' => 'App\Models\Whiteboard',
        ];

        $types = DB::table('entity_types')
            ->whereNull('campaign_id')
            ->where('is_special', false)
            ->whereIn('code', array_keys($classes))
            ->pluck('id', 'code');

        foreach ($types as $code => $typeId) {
            DB::table('entities')
                ->where('type_id', $typeId)
                ->whereNull('child_type')
                ->update(['child_type' => $classes[$code]]);
        }
    }

    /**
     * The preceding schema migration removes the column on rollback.
     */
    public function down(): void {}
};

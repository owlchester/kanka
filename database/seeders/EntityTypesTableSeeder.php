<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EntityTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            'character' => 'fa-user',
            'family' => 'fa-family',
            'location' => 'fa-circle-location-arrow',
            'organisation' => 'fa-screen-users',
            'item' => 'fa-gem',
            'note' => 'fa-book-open',
            'event' => 'fa-cake-candles',
            'calendar' => 'fa-calendar',
            'race' => 'fa-person-fairy',
            'quest' => 'fa-sign-hanging',
            'journal' => 'fa-books',
            'tag' => 'fa-tags',
            'dice_roll' => 'fa-dice',
            'conversation' => 'fa-comments',
            'attribute_template' => 'fa-file-export',
            'ability' => 'fa-fire',
            'map' => 'fa-map',
            'timeline' => 'fa-list-timeline',
            'bookmark' => 'fa-bookmark',
            'creature' => 'fa-deer',
            'whiteboard' => 'fa-chalkboard',
        ];
        $position = 1;
        $created = 0;
        foreach ($types as $code => $icon) {
            $type = \App\Models\EntityType::default()->firstOrNew([
                'code' => $code,
            ]);
//            if (! $type->exists) {
//                continue;
//            }
            $type->fill([
                'code' => $code,
                'is_enabled' => true,
                'is_special' => false,
                'position' => $position,
                'icon' => $icon,
            ])->save();
            $created++;
            $position++;
        }
    }
}

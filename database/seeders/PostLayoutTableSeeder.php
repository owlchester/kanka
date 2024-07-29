<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

//use App\Models\PostLayout;

class PostLayoutTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $layouts = ['abilities', 'assets', 'attributes', 'connection_map', 'inventory', 'character_orgs', 'quest_elements', 'location_characters', 'location_events', 'reminders'];
        foreach ($layouts as $code) {
            $entity_type = null;
            if ($code == 'character_orgs') {
                $entity_type = config('entities.ids.character');
            } elseif ($code == 'quest_elements') {
                $entity_type = config('entities.ids.quest');
            } elseif (in_array($code, ['location_characters', 'location_events'])) {
                $entity_type = config('entities.ids.location');
            }

            $layout = \App\Models\PostLayout::firstOrNew([
                'code' => $code,
            ]);
            if (!$layout->exists) {
                $layout->fill([
                    'code' => $code,
                    'entity_type_id' => $entity_type,
                ])->save();
            }
        }
    }
}

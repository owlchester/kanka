<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
//use App\Models\PostLayout;
use Illuminate\Support\Facades\DB;

class PostLayoutTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $layouts = ['abilities', 'assets', 'attributes', 'connection_map', 'inventory', 'character_orgs', 'quest_elements', 'location_characters'];
        foreach ($layouts as $layout) {
            $entity_type = null;
            if ($layout == 'character_orgs') {
                $entity_type = config('entities.ids.character');
            } elseif ($layout == 'quest_elements') {
                $entity_type = config('entities.ids.quest');
            } elseif ($layout == 'location_characters') {
                $entity_type = config('entities.ids.location');
            }
            DB::table('post_layouts')->insert([
                'code' => $layout,
                'entity_type_id' => $entity_type,
            ]);
        }
    }
}

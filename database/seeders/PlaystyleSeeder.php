<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Playstyle;

class PlaystyleSeeder extends Seeder
{
    public function run(): void
    {
        $slugs = [
            'roleplay-heavy',
            'roleplay-light',
            'story-driven',
            'combat-focused',
            'exploration-focused',
            'sandbox-player-driven',
            'linear-gm-led',
            'tactical-crunchy',
            'rules-light',
            'narrative-first',
            'character-focused',
            'casual-drop-in-friendly',
            'serious-immersive',
            'long-term-campaign',
            'episodic-one-shot-friendly',
        ];

        foreach ($slugs as $slug) {
            Playstyle::firstOrCreate(
                ['slug' => $slug],
                ['campaign_count' => 0]
            );
        }
    }
}
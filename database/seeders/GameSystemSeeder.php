<?php

namespace Database\Seeders;

use App\Models\GameSystem;
use Illuminate\Database\Seeder;

class GameSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ([
            'Starts Without Numbers' => 'Stars Without Number',
            'Call of Cthulu' => 'Call of Cthulhu',
            'Cypther System' => 'Cypher System',
        ] as $oldName => $name) {
            if (! GameSystem::where('name', $name)->exists()) {
                GameSystem::where('name', $oldName)->update(['name' => $name]);
            }
        }

        $genres = [
            'D&D', 'D&D 5e', 'D&D 3.5', 'D&D 3', 'D&D 4', 'AD&D 2',
            'Pathfinder', 'Pathfinder 2e',
            'Savage Worlds',
            'Chronicles of Darkness',
            'GURPS',
            'Fate',
            'Dungeon World',
            'DSA',
            'Powered by the Apocalypse',
            'Ordem Paranormal',
            'Starfinder',
            'Genesys',
            'Shadowrun',
            'Stars Without Number',
            'Call of Cthulhu',
            'World of Darkness',
            'Cyberpunk Red',
            'Ironsworn',
            'Blades in the Dark',
            'Homebrew',
            'Other',
            'Forbidden Lands',
            'Traveller',
            'Cypher System',
            'Vampire the Masquerade',
            'Lancer',
            'Tormenta 20',
            'Fabula Ultima',
            'Cyberpunk 2020',
            'Symbaroum',
            'Warhammer',
            '13th Age',
            'Monster of the Week',
            'Mythras',
            'Numenera',
            'Cortex Prime',
            'Legend of the Five Rings',
            '7th Sea',
            'Fantasy AGE',
            'Knight',
            'Star Wars',
            'Tales from the Loop',
            'The One Ring',
            'Year Zero Engine',
            'Exalted',
            'Mörk Borg',
            'Mutant Year Zero',
            'None',
            'Pendragon',
            'Witcher',
            'OSR',
            'Zweihander',
            'Delta Green',
            'Earthdawn',
            'Masks',
            'Draw Steel',
            'Daggerheart',
            'Candela Obscura',
            'Shadowdark',
            'Dragonbane',
            'Mothership',
            'Alien RPG',
            'Vaesen',
            'Cairn',
            'Mausritter',
            'Pirate Borg',
            'Wildsea',
            'Worlds Without Number',
            'Cities Without Number',
            'D&D 2024',
            'Starfinder 2e',
        ];
        foreach ($genres as $name) {
            $genre = GameSystem::firstOrNew([
                'name' => $name,
            ]);
            if ($genre->exists) {
                continue;
            }
            $genre->fill([
                'name' => $name,
            ])->save();
        }
    }
}

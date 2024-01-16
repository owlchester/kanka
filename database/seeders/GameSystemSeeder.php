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
        $genres = [
            'D&D', 'D&D 5e', 'D&D 3.5', 'D&D 3', 'D&D 4', 'AD&D 2' .
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
            'Starts Without Numbers',
            'Call of Cthulu',
            'World of Darkness',
            'Cyberpunk Red',
            'Ironsworn',
            'Blades in the Dark',
            'Homebrew',
            'Other',
            'Forbidden Lands',
            'Traveller',
            'Cypther System',
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

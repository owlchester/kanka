<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;

class GenreTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genres = ['alternate_history', 'cyberpunk', 'fantasy', 'historical', 'many_worlds', 'modern', 'occult', 'post_apocalyptic', 'pulp', 'science_fiction', 'science_fantasy', 'space_opera', 'steampunk', 'superhero', 'urban_fantasy', 'western'];
        foreach ($genres as $genre) {
            $genre = Genre::firstOrNew([
                'slug' => $genre,
            ]);
            if ($genre->exists) {
                continue;
            }
            $genre->fill([
                'slug' => $genre,
            ])->save();
        }
    }
}

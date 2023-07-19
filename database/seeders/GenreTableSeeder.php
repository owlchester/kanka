<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenreTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genres = ['alternate_history', 'cyberpunk', 'fantasy', 'historical', 'many_worlds', 'modern', 'occult', 'post_apocalyptic', 'pulp', 'science_fiction', 'science_fantasy', 'space_opera', 'steampunk', 'superhero', 'urban_fantasy', 'western'];
        foreach ($genres as $genre) {
            DB::table('genres')->insert([
                'slug' => $genre,
            ]);
        }
    }
}

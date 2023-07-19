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
        $layouts = ['abilities', 'assets', 'attributes', 'connection_map', 'inventory'];
        foreach ($layouts as $layout) {
            DB::table('post_layouts')->insert([
                'code' => $layout,
            ]);
        }
    }
}

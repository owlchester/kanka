<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ThemesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $themes = ['default', 'dark', 'midnight'];
        $created = 0;
        foreach ($themes as $theme) {
            $type = \App\Models\Theme::firstOrNew([
                'name' => $theme,
            ]);
            if (! $type->exists) {
                $type->fill([
                    'name' => $theme,
                ])->save();
                $created++;
            }
        }
    }
}

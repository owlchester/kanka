<?php

namespace Database\Seeders;

use App\Models\Visibility;
use Illuminate\Database\Seeder;

class VisibilitiesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
    {
        $themes = ['all', 'admin', 'admin-self', 'self', 'members'];
        $created = 0;
        foreach ($themes as $theme) {
            $type = Visibility::firstOrNew([
                'code' => $theme,
            ]);
            if (! $type->exists) {
                $type->fill([
                    'code' => $theme,
                ])->save();
                $created++;
            }
        }
    }
}

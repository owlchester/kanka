<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(CampaignBoostCount::class);
        $this->call(EntityTypesTableSeeder::class);
        //$this->call(RpgSystemsTableSeeder::class);
        //$this->call(ThemesTableSeeder::class);
    }
}

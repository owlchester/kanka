<?php

namespace Database\Factories;

// use Faker\Generator as Faker;
use App\Models\Calendar;
use Illuminate\Database\Eloquent\Factories\Factory;

class CalendarFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Calendar::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'entry' => '<p>' . fake()->text(500) . '<p>',
            'name' => 'Gregorian',
            'months' => '[{"name":"January","length":31,"type":"standard","alias":""},{"name":"February","length":28,"type":"standard","alias":""},{"name":"March","length":31,"type":"standard","alias":""},{"name":"April","length":30,"type":"standard","alias":""},{"name":"Mai","length":31,"type":"standard","alias":""},{"name":"June","length":30,"type":"standard","alias":""},{"name":"July","length":31,"type":"standard","alias":""},{"name":"August","length":31,"type":"standard","alias":""},{"name":"September","length":30,"type":"standard","alias":""},{"name":"October","length":31,"type":"standard","alias":""},{"name":"November","length":30,"type":"standard","alias":""},{"name":"December","length":31,"type":"standard","alias":""}]',
            'weekdays' => '["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"]',
            'seasons' => '[{"name":"Spring","month":3,"day":21},{"name":"Summer","month":6,"day":21},{"name":"Autumn","month":9,"day":21},{"name":"Winter","month":12,"day":21}]',
            'suffix' => 'AD',
            'has_leap_year' => 1,
            'leap_year_amount' => 1,
            'leap_year_month' => 2,
            'leap_year_offset' => 4,
            'leap_year_start' => 4,
            'skip_year_zero' => 1,
            'start_offset' => 5,
            'is_incrementing' => 1,
        ];
    }
}

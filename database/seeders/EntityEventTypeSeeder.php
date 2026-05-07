<?php

namespace Database\Seeders;

use App\Enums\EntityEventTypes;
use App\Models\EntityEventType;
use Illuminate\Database\Seeder;

class EntityEventTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [EntityEventTypes::birth, EntityEventTypes::death, EntityEventTypes::calendarDate, EntityEventTypes::founded];
        $created = 0;
        foreach ($types as $type) {
            $exists = EntityEventType::query()->where('id', $type->value)->exists();
            if (! $exists) {
                EntityEventType::query()->insert(['id' => $type->value, 'name' => $type->name]);
                $created++;
            }
        }
    }
}

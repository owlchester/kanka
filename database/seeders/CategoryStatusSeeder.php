<?php

namespace Database\Seeders;

use App\Models\EntityType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            'character' => [
                ['key' => 'alive', 'icon' => null, 'sort_order' => 1, 'is_default' => true],
                ['key' => 'missing', 'icon' => 'fa-question', 'sort_order' => 2, 'is_default' => false],
                ['key' => 'dead', 'icon' => 'fa-skull', 'sort_order' => 3, 'is_default' => false],
            ],
            'creature' => [
                ['key' => 'dead', 'icon' => 'fa-skull', 'sort_order' => 1, 'is_default' => false],
                ['key' => 'extinct', 'icon' => 'fa-skull-crossbones', 'sort_order' => 2, 'is_default' => false],
            ],
            'location' => [
                ['key' => 'destroyed', 'icon' => 'fa-house-crack', 'sort_order' => 1, 'is_default' => false],
            ],
            'race' => [
                ['key' => 'extinct', 'icon' => 'fa-skull-crossbones', 'sort_order' => 1, 'is_default' => false],
            ],
            'quest' => [
                ['key' => 'not_started', 'icon' => null, 'sort_order' => 1, 'is_default' => true],
                ['key' => 'ongoing', 'icon' => 'fa-spinner', 'sort_order' => 2, 'is_default' => false],
                ['key' => 'completed', 'icon' => 'fa-check', 'sort_order' => 3, 'is_default' => false],
                ['key' => 'abandoned', 'icon' => 'fa-ban', 'sort_order' => 4, 'is_default' => false],
            ],
            'family' => [
                ['key' => 'extinct', 'icon' => 'fa-skull-crossbones', 'sort_order' => 1, 'is_default' => false],
            ],
            'organisation' => [
                ['key' => 'defunct', 'icon' => 'fa-ban', 'sort_order' => 1, 'is_default' => false],
            ],
            'item' => [
                ['key' => 'owned', 'icon' => null, 'sort_order' => 1, 'is_default' => false],
                ['key' => 'lost', 'icon' => 'fa-question', 'sort_order' => 2, 'is_default' => false],
                ['key' => 'destroyed', 'icon' => 'fa-house-crack', 'sort_order' => 3, 'is_default' => false],
            ],
        ];

        foreach ($statuses as $code => $categoryStatuses) {
            $entityType = EntityType::where('code', $code)->first();
            if (! $entityType) {
                continue;
            }

            foreach ($categoryStatuses as $status) {
                DB::table('category_statuses')->updateOrInsert(
                    [
                        'category_id' => $entityType->id,
                        'key' => $status['key'],
                    ],
                    [
                        'icon' => $status['icon'],
                        'sort_order' => $status['sort_order'],
                        'is_default' => $status['is_default'],
                    ]
                );
            }
        }
    }
}

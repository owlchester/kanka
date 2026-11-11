<?php

namespace Database\Seeders;

use App\Models\EntityType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryStatusSeeder extends Seeder
{
    private const RESERVED_IDS = [
        'character' => ['alive' => 1, 'missing' => 2, 'dead' => 3],
        'creature' => ['dead' => 4, 'extinct' => 5],
        'location' => ['destroyed' => 6],
        'race' => ['extinct' => 7],
        'quest' => ['not_started' => 8, 'ongoing' => 9, 'completed' => 10, 'abandoned' => 11],
        'family' => ['extinct' => 12],
        'organisation' => ['defunct' => 13],
        'item' => ['owned' => 14, 'lost' => 15, 'destroyed' => 16],
    ];

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
                $reservedId = self::RESERVED_IDS[$code][$status['key']];
                $existing = DB::table('category_statuses')->whereNull('campaign_id')->where('category_id', $entityType->id)->where('key', $status['key'])->first();
                if (! $existing && DB::table('category_statuses')->where('id', $reservedId)->exists()) {
                    throw new \RuntimeException('Reserved category status ID is already occupied: ' . $reservedId);
                }
                DB::table('category_statuses')->updateOrInsert(
                    [
                        ...($existing ? [] : ['id' => $reservedId]),
                        'campaign_id' => null,
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

<?php

use App\Services\Families\FamilyTreeGraphConverter;
use Illuminate\Support\Str;

it('converts a legacy partner and child branch into independent graph edges', function () {
    $graph = (new FamilyTreeGraphConverter)->convert([
        [
            'entity_id' => 10,
            'uuid' => 'founder',
            'relations' => [
                [
                    'entity_id' => 20,
                    'uuid' => 'partner',
                    'role' => 'Former partner',
                    'children' => [
                        [
                            'entity_id' => 30,
                            'uuid' => 'child',
                        ],
                    ],
                ],
            ],
        ],
    ]);

    expect($graph['nodes'])->toHaveCount(3)
        ->and($graph['edges'])->toHaveCount(3);

    $types = array_count_values(array_column($graph['edges'], 'type'));
    expect($types)->toBe(['partner' => 1, 'parent' => 2]);

    $parentEdges = array_values(array_filter($graph['edges'], fn (array $edge): bool => $edge['type'] === 'parent'));
    $childId = collect($graph['nodes'])->firstWhere('entity_id', 30)['id'];
    expect(array_column($parentEdges, 'target'))->toBe([$childId, $childId]);
});

it('keeps unknown people and gives every graph element a unique uuid', function () {
    $graph = (new FamilyTreeGraphConverter)->convert([
        [
            'entity_id' => 10,
            'uuid' => 'not-a-uuid',
            'relations' => [
                [
                    'isUnknown' => true,
                    'uuid' => 'not-a-uuid',
                ],
            ],
        ],
    ]);

    $nodeIds = array_column($graph['nodes'], 'id');
    $edgeIds = array_column($graph['edges'], 'id');

    expect($graph['nodes'][1]['isUnknown'])->toBeTrue()
        ->and($graph['nodes'][1]['entity_id'])->toBeNull()
        ->and($nodeIds)->toHaveCount(2)
        ->and(array_unique($nodeIds))->toHaveCount(2)
        ->and($edgeIds)->toHaveCount(1)
        ->and(Str::isUuid($nodeIds[0]))->toBeTrue()
        ->and(Str::isUuid($edgeIds[0]))->toBeTrue();
});

it('normalises flat graph ids and discards edges with missing endpoints', function () {
    $graph = (new FamilyTreeGraphConverter)->convert([
        'nodes' => [
            ['id' => 'one', 'entity_id' => 10],
            ['id' => 'two', 'entity_id' => 20],
        ],
        'edges' => [
            ['id' => 'edge', 'source' => 'one', 'target' => 'two', 'type' => 'parent'],
            ['id' => 'orphan', 'source' => 'one', 'target' => 'missing', 'type' => 'partner'],
        ],
    ]);

    expect($graph['nodes'])->toHaveCount(2)
        ->and($graph['edges'])->toHaveCount(1)
        ->and($graph['edges'][0]['source'])->toBe($graph['nodes'][0]['id'])
        ->and($graph['edges'][0]['target'])->toBe($graph['nodes'][1]['id'])
        ->and(Str::isUuid($graph['edges'][0]['id']))->toBeTrue();
});

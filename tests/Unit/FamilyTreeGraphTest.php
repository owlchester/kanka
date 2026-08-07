<?php

use App\Enums\FamilyTreeChildType;
use App\Services\Families\FamilyTreeGraph;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

uses(TestCase::class);

it('converts a nested family tree into a graph with shared children', function () {
    $graph = FamilyTreeGraph::fromLegacy([
        [
            'entity_id' => 1,
            'relations' => [
                [
                    'entity_id' => 2,
                    'role' => 'Spouse',
                    'children' => [
                        ['entity_id' => 3],
                    ],
                ],
            ],
        ],
    ]);

    expect($graph['version'])->toBe(2)
        ->and($graph['nodes'])->toHaveCount(3)
        ->and($graph['edges'])->toHaveCount(3);

    $partner = collect($graph['edges'])->firstWhere('type', 'partner');
    expect($partner['role'])->toBe('Spouse');

    expect(collect($graph['edges'])->where('type', 'child')->pluck('child_type')->all())
        ->each->toBe(FamilyTreeChildType::Biological->value);
});

it('keeps custom child roles and rejects custom children without a role', function () {
    $graph = FamilyTreeGraph::prepare([
        'nodes' => [
            ['id' => 'parent', 'entity_id' => 1],
            ['id' => 'child', 'entity_id' => 2],
        ],
        'edges' => [[
            'id' => 'edge',
            'source' => 'parent',
            'target' => 'child',
            'type' => 'child',
            'child_type' => FamilyTreeChildType::Custom->value,
            'role' => 'Ward',
        ]],
    ]);

    FamilyTreeGraph::validate($graph);
    expect($graph['edges'][0]['role'])->toBe('Ward');

    $graph['edges'][0]['role'] = null;
    expect(fn () => FamilyTreeGraph::validate($graph))->toThrow(ValidationException::class);
});

it('rejects cycles in child relationships', function () {
    $graph = FamilyTreeGraph::prepare([
        'nodes' => [
            ['id' => 'one'],
            ['id' => 'two'],
        ],
        'edges' => [
            ['id' => 'one-edge', 'source' => 'one', 'target' => 'two', 'type' => 'child'],
            ['id' => 'two-edge', 'source' => 'two', 'target' => 'one', 'type' => 'child'],
        ],
    ]);

    expect(fn () => FamilyTreeGraph::validate($graph))->toThrow(ValidationException::class);
});

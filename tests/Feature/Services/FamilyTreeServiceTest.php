<?php

use App\Models\Campaign;
use App\Models\Character;
use App\Models\Family;
use App\Models\FamilyTree;
use App\Services\Families\FamilyTreeGraph;
use App\Services\Families\FamilyTreeService;

it('saves and loads direct child and former partner graph edges', function () {
    $this->asUser()->withCampaign(['boost_count' => 4])->withFamilies()->withCharacters();

    $family = Family::firstOrFail();
    $characters = Character::all();
    $nodes = $characters->take(3)->map(fn (Character $character) => [
        'id' => 'node-' . $character->id,
        'entity_id' => $character->entity->id,
    ])->values()->all();
    $graph = FamilyTreeGraph::prepare([
        'nodes' => $nodes,
        'edges' => [
            [
                'id' => 'partner',
                'source' => $nodes[0]['id'],
                'target' => $nodes[1]['id'],
                'type' => 'partner',
                'partner_status' => 'former',
            ],
            [
                'id' => 'child',
                'source' => $nodes[0]['id'],
                'target' => $nodes[2]['id'],
                'type' => 'child',
                'child_type' => 2,
            ],
        ],
    ]);

    $response = app(FamilyTreeService::class)
        ->campaign(Campaign::firstOrFail())
        ->family($family)
        ->save($graph)
        ->api();

    expect($response['version'])->toBe(2)
        ->and($response['nodes'])->toHaveCount(3)
        ->and($response['edges'])->toHaveCount(2)
        ->and(collect($response['edges'])->firstWhere('id', $graph['edges'][0]['id'])['partner_status'])->toBe('former')
        ->and(collect($response['edges'])->firstWhere('id', $graph['edges'][1]['id'])['child_type'])->toBe(2);
});

it('migrates a legacy family tree and is idempotent', function () {
    $this->asUser()->withCampaign()->withFamilies();

    $family = Family::firstOrFail();
    $tree = new FamilyTree;
    $tree->family_id = $family->id;
    $tree->config = [[
        'entity_id' => null,
        'isUnknown' => true,
        'relations' => [[
            'entity_id' => null,
            'isUnknown' => true,
            'children' => [],
        ]],
    ]];
    $tree->save();

    $this->artisan('migrate:family-trees')->assertSuccessful();
    $tree->refresh();
    expect($tree->config['version'])->toBe(2)
        ->and($tree->config['nodes'])->toHaveCount(2)
        ->and($tree->config['edges'])->toHaveCount(1);

    $this->artisan('migrate:family-trees')->assertSuccessful();
    expect(FamilyTree::findOrFail($tree->id)->config['nodes'])->toHaveCount(2);
});

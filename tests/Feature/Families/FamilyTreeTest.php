<?php

use App\Enums\Visibility;
use App\Models\Character;
use App\Models\CharacterFamily;
use App\Models\Family;
use App\Models\FamilyTree;
use Illuminate\Support\Facades\DB;

it('loads an empty family tree in v2 format', function () {
    $this->asUser()
        ->withCampaign(['boost_count' => 4])
        ->withFamilies();

    $family = Family::first();

    $this->getJson("/w/test-campaign/families/{$family->id}/tree/api")
        ->assertSuccessful()
        ->assertJsonPath('graph.version', 2)
        ->assertJsonPath('graph.people', [])
        ->assertJsonPath('graph.unions', [])
        ->assertJsonPath('graph.links', [])
        ->assertJsonPath('is_admin', true);
});

it('auto-converts legacy v1 tree config on load', function () {
    $this->asUser()
        ->withCampaign(['boost_count' => 4])
        ->withFamilies()
        ->withCharacters()
        ->withCharacters();

    $family = Family::first();
    $characters = Character::all();

    FamilyTree::create([
        'family_id' => $family->id,
        'config' => [
            [
                'uuid' => 'legacy-root',
                'entity_id' => $characters[0]->entity->id,
                'relations' => [
                    [
                        'uuid' => 'legacy-unknown',
                        'entity_id' => '',
                        'isUnknown' => true,
                        'children' => [
                            [
                                'uuid' => 'legacy-child',
                                'entity_id' => $characters[1]->entity->id,
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ]);

    $this->getJson("/w/test-campaign/families/{$family->id}/tree/api")
        ->assertSuccessful()
        ->assertJsonPath('graph.version', 2)
        ->assertJsonCount(2, 'graph.people')
        ->assertJsonCount(0, 'graph.unions')
        ->assertJsonCount(1, 'graph.links')
        ->assertJsonPath('graph.links.0.parent_id', 'legacy-root')
        ->assertJsonPath('graph.links.0.child_id', 'legacy-child');
});

it('saves a v2 tree, assigns uuids, and syncs family_tree_entities', function () {
    $this->asUser()
        ->withCampaign(['boost_count' => 4])
        ->withFamilies()
        ->withCharacters()
        ->withCharacters();

    $family = Family::first();
    $characters = Character::all();
    $e1 = $characters[0]->entity->id;
    $e2 = $characters[1]->entity->id;

    $payload = [
        'version' => 2,
        'settings' => ['direction' => 'LR', 'edgeStyle' => 'orthogonal', 'compact' => true],
        'people' => [
            ['id' => 'temp-1', 'entity_id' => $e1, 'placeholder' => null, 'visibility' => Visibility::All->value],
            ['id' => 'temp-2', 'entity_id' => null, 'placeholder' => ['name' => 'Great Uncle Jim', 'subtitle' => 'BBEG'], 'visibility' => Visibility::All->value],
            ['id' => 'temp-3', 'entity_id' => $e2, 'placeholder' => null, 'visibility' => Visibility::All->value],
        ],
        'unions' => [],
        'links' => [
            ['id' => 'temp-l1', 'union_id' => null, 'parent_id' => 'temp-1', 'child_id' => 'temp-3', 'kind' => 'adopted', 'visibility' => Visibility::All->value],
        ],
    ];

    $response = $this->postJson("/w/test-campaign/families/{$family->id}/tree/api", ['data' => $payload])
        ->assertSuccessful()
        ->assertJsonPath('graph.version', 2)
        ->assertJsonPath('graph.settings.direction', 'LR')
        ->assertJsonPath('graph.settings.compact', true)
        ->assertJsonCount(3, 'graph.people')
        ->assertJsonPath('graph.people.1.placeholder.name', 'Great Uncle Jim')
        ->assertJsonPath('graph.links.0.kind', 'adopted');

    $tree = FamilyTree::where('family_id', $family->id)->firstOrFail();
    $synced = DB::table('family_tree_entities')
        ->where('family_tree_id', $tree->id)
        ->pluck('entity_id')
        ->sort()
        ->values()
        ->all();

    expect($synced)->toBe(collect([$e1, $e2])->sort()->values()->all());
});

it('blocks saving family tree for non-premium campaigns', function () {
    $this->asUser()
        ->withCampaign(['boost_count' => 0])
        ->withFamilies();

    $family = Family::first();

    $this->postJson("/w/test-campaign/families/{$family->id}/tree/api", [
        'data' => ['version' => 2, 'people' => [], 'unions' => [], 'links' => []],
    ])->assertStatus(204);
});

it('filters nodes by visibility and supports admin preview_visibility', function () {
    $this->asUser()
        ->withCampaign(['boost_count' => 4])
        ->withFamilies()
        ->withCharacters()
        ->withCharacters();

    $family = Family::first();
    $characters = Character::all();

    FamilyTree::create([
        'family_id' => $family->id,
        'config' => [
            'version' => 2,
            'people' => [
                ['id' => 'p-all', 'entity_id' => $characters[0]->entity->id, 'visibility' => Visibility::All->value],
                ['id' => 'p-admin', 'entity_id' => $characters[1]->entity->id, 'visibility' => Visibility::Admin->value],
            ],
            'unions' => [],
            'links' => [
                ['id' => 'l-1', 'union_id' => null, 'parent_id' => 'p-all', 'child_id' => 'p-admin', 'kind' => 'biological', 'visibility' => Visibility::Admin->value],
            ],
        ],
    ]);

    // Admin sees both by default
    $this->getJson("/w/test-campaign/families/{$family->id}/tree/api")
        ->assertSuccessful()
        ->assertJsonCount(2, 'graph.people')
        ->assertJsonCount(1, 'graph.links');

    // Admin previewing as public ('all') sees only public node and pruned link
    $this->getJson("/w/test-campaign/families/{$family->id}/tree/api?preview_visibility=all")
        ->assertSuccessful()
        ->assertJsonCount(1, 'graph.people')
        ->assertJsonPath('graph.people.0.id', 'p-all')
        ->assertJsonCount(0, 'graph.links');
});

it('discovers linked trees for shared characters while respecting privacy', function () {
    $this->asUser()
        ->withCampaign(['boost_count' => 4])
        ->withFamilies()
        ->withFamilies()
        ->withCharacters();

    $families = Family::all();
    $character = Character::first();
    $entityId = $character->entity->id;

    FamilyTree::create([
        'family_id' => $families[0]->id,
        'config' => [
            'version' => 2,
            'people' => [['id' => 'p-1', 'entity_id' => $entityId, 'visibility' => Visibility::All->value]],
            'unions' => [],
            'links' => [],
        ],
    ]);

    FamilyTree::create([
        'family_id' => $families[1]->id,
        'config' => [
            'version' => 2,
            'people' => [['id' => 'p-2', 'entity_id' => $entityId, 'visibility' => Visibility::All->value]],
            'unions' => [],
            'links' => [],
        ],
    ]);

    $this->getJson("/w/test-campaign/families/{$families[0]->id}/tree/api")
        ->assertSuccessful()
        ->assertJsonPath("linked_trees.{$entityId}.0.family_id", $families[1]->id)
        ->assertJsonPath("linked_trees.{$entityId}.0.name", $families[1]->entity->name);
});

it('prunes deleted character entities without breaking the rest of the tree', function () {
    $this->asUser()
        ->withCampaign(['boost_count' => 4])
        ->withFamilies()
        ->withCharacters()
        ->withCharacters();

    $family = Family::first();
    $characters = Character::all();
    $deletedId = $characters[1]->entity->id;
    $characters[1]->entity->delete();

    FamilyTree::create([
        'family_id' => $family->id,
        'config' => [
            'version' => 2,
            'people' => [
                ['id' => 'p-1', 'entity_id' => $characters[0]->entity->id, 'visibility' => Visibility::All->value],
                ['id' => 'p-2', 'entity_id' => $deletedId, 'visibility' => Visibility::All->value],
            ],
            'unions' => [],
            'links' => [
                ['id' => 'l-1', 'union_id' => null, 'parent_id' => 'p-1', 'child_id' => 'p-2', 'kind' => 'biological', 'visibility' => Visibility::All->value],
            ],
        ],
    ]);

    $this->getJson("/w/test-campaign/families/{$family->id}/tree/api")
        ->assertSuccessful()
        ->assertJsonCount(1, 'graph.people')
        ->assertJsonPath('graph.people.0.id', 'p-1')
        ->assertJsonCount(0, 'graph.links');
});

it('promotes a placeholder to a real character and attaches them to the family', function () {
    $this->asUser()
        ->withCampaign(['boost_count' => 4])
        ->withFamilies();

    $family = Family::first();

    $response = $this->postJson("/w/test-campaign/families/{$family->id}/tree/promote-character", [
        'name' => 'Great Uncle Jim',
        'add_to_family' => true,
    ])
        ->assertStatus(201)
        ->assertJsonPath('name', 'Great Uncle Jim');

    $entityId = $response->json('id');
    $character = Character::whereHas('entity', fn ($q) => $q->where('id', $entityId))->firstOrFail();

    expect(CharacterFamily::where('character_id', $character->id)->where('family_id', $family->id)->exists())->toBeTrue();
});

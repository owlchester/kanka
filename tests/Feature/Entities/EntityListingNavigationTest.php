<?php

use App\Models\EntityType;
use App\Models\Organisation;
use Illuminate\Support\Arr;

it('keeps nested sibling navigation separate from persisted filters', function () {
    $this->asUser()->withCampaign();

    $root = Organisation::factory()->create([
        'campaign_id' => 1,
        'name' => 'Root organisation',
    ]);
    $firstChild = Organisation::factory()->create([
        'campaign_id' => 1,
        'name' => 'First child',
    ]);
    $secondChild = Organisation::factory()->create([
        'campaign_id' => 1,
        'name' => 'Second child',
    ]);
    $firstGrandchild = Organisation::factory()->create([
        'campaign_id' => 1,
        'name' => 'First grandchild',
    ]);
    $secondGrandchild = Organisation::factory()->create([
        'campaign_id' => 1,
        'name' => 'Second grandchild',
    ]);

    $firstChild->entity->update(['parent_id' => $root->entity->id]);
    $secondChild->entity->update(['parent_id' => $root->entity->id]);
    $firstGrandchild->entity->update(['parent_id' => $firstChild->entity->id]);
    $secondGrandchild->entity->update(['parent_id' => $secondChild->entity->id]);

    $entityType = EntityType::findOrFail(config('entities.ids.organisation'));
    $listingUrl = fn (?int $parentId = null, bool $children = true): string => route(
        'entities.index-api',
        array_filter([
            1,
            $entityType,
            'parent_id' => $parentId,
            'children' => $children ?: null,
        ]),
    );
    $entityIds = fn ($response): array => Arr::pluck(
        $response->json('entities.data'),
        'id',
    );
    $filterSessionKey = 'filterService-filter-' . $entityType->id . '-1';

    $rootChildren = $this->getJson($listingUrl($root->entity->id));
    $rootChildren->assertSuccessful();
    expect($entityIds($rootChildren))
        ->toContain($firstChild->entity->id, $secondChild->entity->id);

    $firstChildren = $this->getJson($listingUrl($firstChild->entity->id));
    $firstChildren->assertSuccessful();
    expect($entityIds($firstChildren))->toBe([$firstGrandchild->entity->id]);

    // This mirrors the old back request, which persisted the navigation parent
    // as if it were a user-selected filter.
    $backToRoot = $this->getJson($listingUrl($root->entity->id, false));
    $backToRoot->assertSuccessful();
    expect($entityIds($backToRoot))
        ->toContain($firstChild->entity->id, $secondChild->entity->id)
        ->and(Arr::get(session()->get($filterSessionKey, []), 'parent_id'))
        ->toBe((string) $root->entity->id);

    $secondChildren = $this->getJson($listingUrl($secondChild->entity->id));
    $secondChildren->assertSuccessful();
    expect($entityIds($secondChildren))
        ->toBe([$secondGrandchild->entity->id])
        ->and(Arr::get(session()->get($filterSessionKey, []), 'parent_id'))
        ->toBeNull();

    $backToRoot = $this->getJson($listingUrl($root->entity->id));
    $backToRoot->assertSuccessful();
    expect($entityIds($backToRoot))
        ->toContain($firstChild->entity->id, $secondChild->entity->id);

    $backToTopLevel = $this->getJson($listingUrl());
    $backToTopLevel->assertSuccessful();
    expect($entityIds($backToTopLevel))->toBe([$root->entity->id]);
});

it('lists accessible nested entities when their parent is not visible', function () {
    $this->asUser()->withCampaign();

    $visibleChild = Organisation::factory()->create([
        'campaign_id' => 1,
        'name' => 'Visible child',
    ]);
    $visibleChild->entity->update(['parent_id' => 999999]);

    $entityType = EntityType::findOrFail(config('entities.ids.organisation'));
    $response = $this->getJson(route('entities.index-api', [1, $entityType]));

    $response->assertSuccessful();
    expect(Arr::pluck($response->json('entities.data'), 'id'))
        ->toContain($visibleChild->entity->id);
});

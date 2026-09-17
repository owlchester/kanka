<?php

use App\Models\Campaign;
use App\Models\CategoryStatus;
use App\Models\EntityType;
use Illuminate\Database\QueryException;

it('only returns global and current campaign statuses', function () {
    $this->asUser()->withCampaign();

    $campaign = Campaign::findOrFail(1);
    $otherCampaign = Campaign::factory()->create();
    $entityType = EntityType::default()->firstOrFail();

    $globalStatus = CategoryStatus::create([
        'category_id' => $entityType->id,
        'key' => 'global',
    ]);
    $campaignStatus = CategoryStatus::create([
        'campaign_id' => $campaign->id,
        'category_id' => $entityType->id,
        'key' => 'campaign',
    ]);
    $otherStatus = CategoryStatus::create([
        'campaign_id' => $otherCampaign->id,
        'category_id' => $entityType->id,
        'key' => 'other',
    ]);

    $this->getJson("/api/1.0/campaigns/{$campaign->id}/category_statuses")
        ->assertOk()
        ->assertJsonCount(2, 'data')
        ->assertJsonFragment([
            'id' => $globalStatus->id,
            'campaign_id' => null,
        ])
        ->assertJsonFragment([
            'id' => $campaignStatus->id,
            'campaign_id' => $campaign->id,
        ])
        ->assertJsonMissing([
            'id' => $otherStatus->id,
        ]);
});

it('allows status keys to be reused across campaigns and categories', function () {
    $this->asUser()->withCampaign();

    $campaign = Campaign::findOrFail(1);
    $otherCampaign = Campaign::factory()->create();
    $entityTypes = EntityType::default()->limit(2)->get();

    CategoryStatus::create([
        'campaign_id' => $campaign->id,
        'category_id' => $entityTypes[0]->id,
        'key' => 'missing',
    ]);
    CategoryStatus::create([
        'campaign_id' => $campaign->id,
        'category_id' => $entityTypes[1]->id,
        'key' => 'missing',
    ]);
    CategoryStatus::create([
        'campaign_id' => $otherCampaign->id,
        'category_id' => $entityTypes[0]->id,
        'key' => 'missing',
    ]);
    CategoryStatus::create([
        'category_id' => $entityTypes[0]->id,
        'key' => 'missing',
    ]);

    expect(CategoryStatus::where('key', 'missing')->count())->toBe(4);
});

it('rejects duplicate status keys for the same campaign and category', function () {
    $this->asUser()->withCampaign();

    $entityType = EntityType::default()->firstOrFail();
    $attributes = [
        'campaign_id' => 1,
        'category_id' => $entityType->id,
        'key' => 'missing',
    ];

    CategoryStatus::create($attributes);

    expect(fn () => CategoryStatus::create($attributes))->toThrow(QueryException::class);
});

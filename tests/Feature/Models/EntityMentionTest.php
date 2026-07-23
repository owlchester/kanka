<?php

use App\Models\Campaign;
use App\Models\EntityMention;
use App\Models\Post;
use App\Models\QuestElement;
use App\Models\TimelineElement;

test('exposes virtual owner-id attributes derived from mentionable_type/mentionable_id', function () {
    $this->asUser()->withCampaign();

    $postMention = EntityMention::create([
        'mentionable_type' => Post::class,
        'mentionable_id' => 42,
        'entity_id' => 7,
        'target_id' => 1,
    ]);
    expect($postMention->post_id)->toBe(42);
    expect($postMention->timeline_element_id)->toBeNull();
    expect($postMention->quest_element_id)->toBeNull();
    expect($postMention->campaign_id)->toBeNull();
    expect($postMention->isPost())->toBeTrue();
    expect($postMention->isTimelineElement())->toBeFalse();
    expect($postMention->isQuestElement())->toBeFalse();
    expect($postMention->isCampaign())->toBeFalse();
    expect($postMention->isEntity())->toBeTrue();

    $timelineMention = EntityMention::create([
        'mentionable_type' => TimelineElement::class,
        'mentionable_id' => 5,
        'entity_id' => 7,
        'target_id' => 1,
    ]);
    expect($timelineMention->timeline_element_id)->toBe(5);
    expect($timelineMention->isTimelineElement())->toBeTrue();

    $questMention = EntityMention::create([
        'mentionable_type' => QuestElement::class,
        'mentionable_id' => 9,
        'entity_id' => 7,
        'target_id' => 1,
    ]);
    expect($questMention->quest_element_id)->toBe(9);
    expect($questMention->isQuestElement())->toBeTrue();

    $campaignMention = EntityMention::create([
        'mentionable_type' => Campaign::class,
        'mentionable_id' => 1,
        'entity_id' => null,
        'target_id' => 1,
    ]);
    expect($campaignMention->campaign_id)->toBe(1);
    expect($campaignMention->isCampaign())->toBeTrue();
    // isEntity() checks entity_id (unchanged, rollup semantics), not mentionable_type.
    expect($campaignMention->isEntity())->toBeFalse();
});

test('scopeOnX filters by mentionable_type', function () {
    $this->asUser()->withCampaign();

    EntityMention::create(['mentionable_type' => Post::class, 'mentionable_id' => 1, 'entity_id' => 7, 'target_id' => 1]);
    EntityMention::create(['mentionable_type' => Campaign::class, 'mentionable_id' => 1, 'target_id' => 1]);

    expect(EntityMention::onPost()->count())->toBe(1);
    expect(EntityMention::onCampaign()->count())->toBe(1);
    expect(EntityMention::onEntity()->count())->toBe(0);
});

test('scopeDatagridElements no longer references the dropped campaign_id column', function () {
    $this->asUser()->withCampaign();

    EntityMention::create(['mentionable_type' => Campaign::class, 'mentionable_id' => 1, 'target_id' => 1]);

    // This would throw a SQL error ("column campaign_id does not exist") if the
    // orderBy still referenced the dropped column.
    expect(fn () => EntityMention::datagridElements(['k' => 'name', 'o' => 'asc'])->get())->not->toThrow(Exception::class);
});

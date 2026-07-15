<?php

use App\Models\Campaign;
use App\Models\EntityMention;
use App\Models\Post;
use App\Models\QuestElement;
use App\Models\Quest;
use App\Models\TimelineElement;
use App\Models\Timeline;

test('Post::mentions() returns only this post\'s owned mentions', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $post = Post::factory()->create(['entity_id' => 1]);
    $otherPost = Post::factory()->create(['entity_id' => 1]);

    EntityMention::create(['mentionable_type' => Post::class, 'mentionable_id' => $post->id, 'entity_id' => 1, 'target_id' => 2]);
    EntityMention::create(['mentionable_type' => Post::class, 'mentionable_id' => $otherPost->id, 'entity_id' => 1, 'target_id' => 2]);

    expect($post->mentions()->count())->toBe(1);
    expect($post->mentions()->first()->mentionable_id)->toBe($post->id);
});

test('TimelineElement::mentions() returns only this element\'s owned mentions', function () {
    $this->asUser()->withCampaign();
    $timeline = Timeline::factory()->create(['campaign_id' => 1]);
    $era = $timeline->eras()->create(['name' => 'Test Era']);
    $element = TimelineElement::factory()->create(['timeline_id' => $timeline->id, 'era_id' => $era->id]);

    EntityMention::create(['mentionable_type' => TimelineElement::class, 'mentionable_id' => $element->id, 'entity_id' => $timeline->entity->id, 'target_id' => 1]);

    expect($element->mentions()->count())->toBe(1);
});

test('QuestElement::mentions() returns only this element\'s owned mentions', function () {
    $this->asUser()->withCampaign();
    $quest = Quest::factory()->create(['campaign_id' => 1]);
    $element = QuestElement::factory()->create(['quest_id' => $quest->id]);

    EntityMention::create(['mentionable_type' => QuestElement::class, 'mentionable_id' => $element->id, 'entity_id' => $quest->entity->id, 'target_id' => 1]);

    expect($element->mentions()->count())->toBe(1);
});

test('Campaign::mentions() returns only this campaign\'s owned mentions', function () {
    $this->asUser()->withCampaign();
    $campaign = Campaign::find(1);

    EntityMention::create(['mentionable_type' => Campaign::class, 'mentionable_id' => $campaign->id, 'target_id' => 1]);

    expect($campaign->mentions()->count())->toBe(1);
});

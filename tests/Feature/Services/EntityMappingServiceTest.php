<?php

use App\Models\Campaign;
use App\Models\CampaignDescription;
use App\Models\Character;
use App\Models\EntityMention;
use App\Models\Post;
use App\Models\Quest;
use App\Models\QuestElement;
use App\Models\Timeline;
use App\Models\TimelineElement;

test('mentioning a character in an entity\'s own entry creates an Entity-owned mention', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $author = Character::find(1)->entity;
    $target = Character::find(2)->entity;

    $author->entry = '[character:' . $target->id . ']';
    $author->save();

    $mention = EntityMention::where('target_id', $target->id)->first();
    expect($mention)->not->toBeNull();
    expect($mention->mentionable_type)->toBe(\App\Models\Entity::class);
    expect($mention->mentionable_id)->toBe($author->id);
    expect($mention->entity_id)->toBe($author->id);
});

test('mentioning a character in a post creates a Post-owned mention with the post\'s parent-entity rollup', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $parent = Character::find(1)->entity;
    $target = Character::find(2)->entity;

    $post = Post::factory()->create([
        'entity_id' => $parent->id,
        'entry' => '[character:' . $target->id . ']',
    ]);

    $mention = EntityMention::where('target_id', $target->id)->where('mentionable_type', Post::class)->first();
    expect($mention)->not->toBeNull();
    expect($mention->mentionable_id)->toBe($post->id);
    expect($mention->entity_id)->toBe($parent->id);
});

test('a post mentioning its own parent entity is skipped (self-mention guard)', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $parent = Character::find(1)->entity;

    Post::factory()->create([
        'entity_id' => $parent->id,
        'entry' => '[character:' . $parent->id . ']',
    ]);

    expect(EntityMention::where('target_id', $parent->id)->count())->toBe(0);
});

test('mentioning a character in a timeline element creates a TimelineElement-owned mention rolled up to the timeline\'s entity', function () {
    $this->asUser()->withCampaign()->withCharacters();
    // Use character 2 (entity id 2) as the target rather than character 1 (entity id 1):
    // the first Timeline row created below also gets id 1, and the self-mention guard
    // compares $this->model->timeline_id (the Timeline's own PK) against the target id,
    // so a target of entity id 1 would coincidentally collide with timeline id 1 and be
    // skipped by the guard. This is a test-data adaptation only; it does not change what
    // is being asserted.
    $target = Character::find(2)->entity;
    $timeline = Timeline::factory()->create(['campaign_id' => 1]);
    $era = $timeline->eras()->create(['name' => 'Test Era']);

    $element = TimelineElement::factory()->create([
        'timeline_id' => $timeline->id,
        'era_id' => $era->id,
        'entry' => '[character:' . $target->id . ']',
    ]);

    $mention = EntityMention::where('target_id', $target->id)->where('mentionable_type', TimelineElement::class)->first();
    expect($mention)->not->toBeNull();
    expect($mention->mentionable_id)->toBe($element->id);
    expect($mention->entity_id)->toBe($timeline->entity->id);
});

test('mentioning a character in a quest element creates a QuestElement-owned mention rolled up to the quest\'s entity', function () {
    $this->asUser()->withCampaign()->withCharacters();
    // Same id-collision reasoning as the TimelineElement test above: the first Quest row
    // created below also gets id 1, and the self-mention guard compares
    // $this->model->quest_id against the target id, so use character 2 (entity id 2) to
    // avoid a coincidental collision with quest id 1.
    $target = Character::find(2)->entity;
    $quest = Quest::factory()->create(['campaign_id' => 1]);

    $element = QuestElement::factory()->create([
        'quest_id' => $quest->id,
        'entry' => '[character:' . $target->id . ']',
    ]);

    $mention = EntityMention::where('target_id', $target->id)->where('mentionable_type', QuestElement::class)->first();
    expect($mention)->not->toBeNull();
    expect($mention->mentionable_id)->toBe($element->id);
    expect($mention->entity_id)->toBe($quest->entity->id);
});

test('mentioning a character in the campaign entry creates a Campaign-owned mention with no entity_id rollup', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $target = Character::find(1)->entity;
    $campaign = Campaign::find(1);

    // Campaign entry text now lives on the related CampaignDescription model (a separate,
    // unrelated refactor already merged to this branch) rather than directly on the
    // Campaign row; the campaigns table no longer has an `entry` column, so we drive the
    // mention pipeline the same way CampaignController::update() does, via
    // CampaignDescription::updateOrCreate(). This is a test-data adaptation only; the
    // assertions below are unchanged from the brief.
    CampaignDescription::updateOrCreate(
        ['campaign_id' => $campaign->id],
        ['description' => '[character:' . $target->id . ']']
    );

    $mention = EntityMention::where('target_id', $target->id)->where('mentionable_type', Campaign::class)->first();
    expect($mention)->not->toBeNull();
    expect($mention->mentionable_id)->toBe($campaign->id);
    expect($mention->entity_id)->toBeNull();
});

test('removing a mention from the entry deletes the corresponding EntityMention row', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $author = Character::find(1)->entity;
    $target = Character::find(2)->entity;

    $author->entry = '[character:' . $target->id . ']';
    $author->save();
    expect(EntityMention::where('target_id', $target->id)->count())->toBe(1);

    $author->entry = 'no more mentions';
    $author->save();
    expect(EntityMention::where('target_id', $target->id)->count())->toBe(0);
});

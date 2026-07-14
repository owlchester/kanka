<?php

use App\Models\Character;
use App\Models\EntityMention;
use App\Models\Post;
use App\Models\Quest;
use App\Models\QuestElement;

test('Entity::mentions() rolls up mentions from the entity\'s own entry and its posts', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $author = Character::find(1)->entity;
    $target = Character::find(2)->entity;

    $author->entry = '[character:' . $target->id . ']';
    $author->save();

    Post::factory()->create([
        'entity_id' => $author->id,
        'entry' => '[character:' . $target->id . ']',
    ]);

    // Two distinct mentions of the same target: one entity-owned, one post-owned,
    // both roll up under $author->mentions() via the shared entity_id column.
    expect($author->mentions()->count())->toBe(2);
    expect($author->mentions()->onEntity()->count())->toBe(1);
});

test('targetMentions() (backlinks) resolves regardless of owner type', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $author = Character::find(1)->entity;
    $target = Character::find(2)->entity;

    $author->entry = '[character:' . $target->id . ']';
    $author->save();

    Post::factory()->create([
        'entity_id' => $author->id,
        'entry' => '[character:' . $target->id . ']',
    ]);

    expect($target->targetMentions()->count())->toBe(2);
});

test('filterValid excludes a QuestElement-owned mention whose quest no longer resolves to an entity', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $target = Character::find(1)->entity;
    $quest = Quest::factory()->create(['campaign_id' => 1]);
    $element = QuestElement::factory()->create(['quest_id' => $quest->id]);

    $mention = EntityMention::create([
        'mentionable_type' => QuestElement::class,
        'mentionable_id' => $element->id,
        'entity_id' => $quest->entity->id,
        'target_id' => $target->id,
    ]);

    expect(EntityMention::filterValid()->whereKey($mention->id)->exists())->toBeTrue();

    $quest->entity->delete();

    expect(EntityMention::filterValid()->whereKey($mention->id)->exists())->toBeFalse();
});

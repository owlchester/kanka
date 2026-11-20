<?php

use App\Facades\CampaignLocalization;
use App\Models\Character;
use App\Services\Images\Avatar;

it('does not leak fallback or size state between calls', function () {
    $this->asUser()->withCampaign();

    $entityA = Character::factory()->create(['campaign_id' => 1])->entity;
    $entityB = Character::factory()->create(['campaign_id' => 1])->entity;

    $withFallback = Avatar::for($entityA)->fallback()->size(80)->thumbnail();
    $withoutFallback = Avatar::for($entityB)->size(40)->thumbnail();

    expect($withFallback)->not->toBeEmpty()
        ->and($withoutFallback)->toBe('');
});

it('resolves entity campaign fallback without global campaign priming', function () {
    $this->asUser()->withCampaign();

    $entity = Character::factory()->create(['campaign_id' => 1])->entity;

    CampaignLocalization::clearCampaign();

    expect(Avatar::for($entity)->fallback()->size(80)->thumbnail())
        ->toBe(asset('/images/defaults/thumbnail.jpg'));
});

it('does not leak entity state after original or hasImage checks', function () {
    $this->asUser()->withCampaign();

    $entityWithPath = Character::factory()->create(['campaign_id' => 1])->entity;
    $entityWithPath->image_path = 'entities/test-avatar.png';
    $entityWithPath->saveQuietly();

    $entityWithoutPath = Character::factory()->create(['campaign_id' => 1])->entity;

    expect(Avatar::for($entityWithPath)->hasImage())->toBeTrue()
        ->and(Avatar::for($entityWithPath)->original())->toContain('entities/test-avatar.png')
        ->and(Avatar::for($entityWithoutPath)->hasImage())->toBeFalse()
        ->and(Avatar::for($entityWithoutPath)->original())->toBe('');
});

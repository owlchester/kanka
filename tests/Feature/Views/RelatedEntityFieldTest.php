<?php

use App\Models\Campaign;
use App\Models\Character;
use App\Models\Organisation;
use App\Models\OrganisationMember;

it('renders the organisation selector when its entity has been deleted', function () {
    $this->asUser()->withCampaign();

    $character = Character::factory()->create(['campaign_id' => 1]);
    $organisation = Organisation::factory()->create(['campaign_id' => 1]);
    $character->organisations()->attach($organisation->id);
    $organisation->entity->delete();

    $html = view('components.form.organisations', [
        'campaign' => Campaign::findOrFail(1),
        'options' => ['model' => $character, 'source' => null],
    ])->render();

    expect($html)->toContain('name="organisations[]"');
});

it('renders the character selector when a member entity has been deleted', function () {
    $this->asUser()->withCampaign();

    $organisation = Organisation::factory()->create(['campaign_id' => 1]);
    $character = Character::factory()->create(['campaign_id' => 1]);
    OrganisationMember::create([
        'organisation_id' => $organisation->id,
        'character_id' => $character->id,
    ]);
    $character->entity->delete();

    $html = view('components.form.characters', [
        'campaign' => Campaign::findOrFail(1),
        'options' => ['model' => $organisation],
        'required' => false,
    ])->render();

    expect($html)->toContain('name="characters[]"');
});

it('renders the organisation members selector when a member entity has been deleted', function () {
    $this->asUser()->withCampaign();

    $organisation = Organisation::factory()->create(['campaign_id' => 1]);
    $character = Character::factory()->create(['campaign_id' => 1]);
    OrganisationMember::create([
        'organisation_id' => $organisation->id,
        'character_id' => $character->id,
    ]);
    $character->entity->delete();

    $html = view('components.form.members', [
        'campaign' => Campaign::findOrFail(1),
        'options' => ['model' => $organisation, 'source' => null],
    ])->render();

    expect($html)->toContain('name="members[]"');
});

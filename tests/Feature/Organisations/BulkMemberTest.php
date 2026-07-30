<?php

use App\Enums\OrganisationMemberPin;
use App\Models\Character;
use App\Models\Organisation;
use App\Models\OrganisationMember;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user)->withCampaign();

    $this->organisation = Organisation::factory()->create(['campaign_id' => 1]);
    $this->character = Character::factory()->create(['campaign_id' => 1]);
    $this->member = OrganisationMember::create([
        'organisation_id' => $this->organisation->id,
        'character_id' => $this->character->id,
        'role' => 'Foot Soldier',
    ]);
});

it('bulk deletes organisation members', function () {
    $this->post("/w/test-campaign/organisations/{$this->organisation->id}/organisation-members/bulk", [
        'action' => 'delete',
        'model' => [$this->member->id],
    ])->assertRedirect();

    $this->assertDatabaseMissing('organisation_member', ['id' => $this->member->id]);
});

it('bulk edit returns dialog view', function () {
    $this->post("/w/test-campaign/organisations/{$this->organisation->id}/organisation-members/bulk", [
        'action' => 'edit',
        'model' => [$this->member->id],
    ])->assertOk()
        ->assertViewIs('layouts.datagrid.bulks.update');
});

it('bulk patches organisation member role', function () {
    $this->post("/w/test-campaign/organisations/{$this->organisation->id}/organisation-members/bulk", [
        'action' => 'patch',
        'model' => [$this->member->id],
        'role' => 'Commander',
    ])->assertRedirect();

    $this->assertDatabaseHas('organisation_member', [
        'id' => $this->member->id,
        'role' => 'Commander',
    ]);
});

it('does not treat the empty pin value as pinned', function () {
    $this->member->pin_id = OrganisationMemberPin::empty;

    expect($this->member->pinned())->toBeFalse()
        ->and($this->member->pinnedToBoth())->toBeFalse();
});

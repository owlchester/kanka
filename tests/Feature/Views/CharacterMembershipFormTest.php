<?php

use App\Enums\OrganisationMemberPin;
use App\Enums\OrganisationMemberStatus;
use App\Models\CampaignPermission;
use App\Models\Character;
use App\Models\Organisation;

beforeEach(function () {
    $this->withoutVite()->asUser()->withCampaign();
});

it('explains empty memberships and provides an inline membership template', function () {
    $this->get(route('characters.create', [1]))
        ->assertSuccessful()
        ->assertSee(__('characters.organisations.form.empty_title'))
        ->assertSee(__('characters.organisations.form.save_hint'))
        ->assertSee('name="character_save_organisations" value="1"', false)
        ->assertSee('name="organisations[__MEMBERSHIP__]"', false)
        ->assertSee('for="membership-role-__MEMBERSHIP__"', false)
        ->assertSee('data-undo-membership', false);
});

it('renders existing membership values with labelled controls', function () {
    $character = Character::factory()->create(['campaign_id' => 1]);
    $organisation = Organisation::factory()->create(['campaign_id' => 1]);
    $member = $character->organisationMemberships()->create([
        'organisation_id' => $organisation->id,
        'role' => 'Guildmaster',
        'status_id' => OrganisationMemberStatus::inactive,
        'pin_id' => OrganisationMemberPin::both,
        'is_private' => true,
    ]);

    $response = $this->get(route('entities.edit', [1, $character->entity]))
        ->assertSuccessful()
        ->assertSee($organisation->entity->name)
        ->assertSee('name="organisations[' . $member->id . ']"', false)
        ->assertSee('value="Guildmaster"', false)
        ->assertSee('id="membership-private-' . $member->id . '" value="1" checked', false)
        ->assertSee(__('characters.organisations.form.private'));

    $document = new DOMDocument;
    @$document->loadHTML($response->getContent());
    $xpath = new DOMXPath($document);
    expect($xpath->evaluate('string(//select[@id="membership-status-' . $member->id . '"]/option[@selected]/@value)'))->toBe('1')
        ->and($xpath->evaluate('string(//select[@id="membership-pin-' . $member->id . '"]/option[@selected]/@value)'))->toBe('3');
});

it('restores membership rows and their settings after validation fails', function () {
    $organisation = Organisation::factory()->create(['campaign_id' => 1]);

    $response = $this->withSession(['_old_input' => [
        'character_save_organisations' => 1,
        'organisations' => ['new_0' => $organisation->id, 'new_2' => ''],
        'organisation_roles' => ['new_0' => 'Spymaster', 'new_2' => 'Unassigned'],
        'organisation_statuses' => ['new_0' => 2, 'new_2' => 0],
        'organisation_pins' => ['new_0' => 1, 'new_2' => ''],
        'organisation_privates' => ['new_0' => 1, 'new_2' => 0],
    ]])->get(route('characters.create', [1]))
        ->assertSuccessful()
        ->assertSee($organisation->entity->name)
        ->assertSee('name="organisations[new_0]"', false)
        ->assertSee('name="organisations[new_2]"', false)
        ->assertSee('value="Spymaster"', false)
        ->assertSee('value="Unassigned"', false)
        ->assertSee('id="membership-private-new_0" value="1" checked', false);

    $document = new DOMDocument;
    @$document->loadHTML($response->getContent());
    $xpath = new DOMXPath($document);
    expect($xpath->evaluate('string(//select[@id="membership-status-new_0"]/option[@selected]/@value)'))->toBe('2')
        ->and($xpath->evaluate('string(//select[@id="membership-pin-new_0"]/option[@selected]/@value)'))->toBe('1');
});

it('does not resurrect removed memberships after a validation failure', function () {
    $character = Character::factory()->create(['campaign_id' => 1]);
    $organisation = Organisation::factory()->create(['campaign_id' => 1]);
    $member = $character->organisationMemberships()->create(['organisation_id' => $organisation->id]);

    $this->withSession(['_old_input' => ['character_save_organisations' => 1]])
        ->get(route('entities.edit', [1, $character->entity]))
        ->assertSuccessful()
        ->assertDontSee('name="organisations[' . $member->id . ']"', false)
        ->assertSee(__('characters.organisations.form.empty_title'));
});

it('carries memberships into a copied character', function () {
    $character = Character::factory()->create(['campaign_id' => 1]);
    $organisation = Organisation::factory()->create(['campaign_id' => 1]);
    $character->organisationMemberships()->create([
        'organisation_id' => $organisation->id,
        'role' => 'Treasurer',
    ]);

    $this->get(route('characters.create', [1, 'copy' => $character->entity->id, 'template' => true]))
        ->assertSuccessful()
        ->assertSee($organisation->entity->name)
        ->assertSee('value="Treasurer"', false);
});

it('does not expose membership privacy controls to non-admins', function () {
    $this->asPlayer();
    CampaignPermission::create([
        'campaign_id' => 1,
        'campaign_role_id' => 3,
        'entity_type_id' => config('entities.ids.character'),
        'action' => CampaignPermission::ACTION_ADD,
        'access' => true,
    ]);

    $this->get(route('characters.create', [1]))
        ->assertSuccessful()
        ->assertSee('data-membership-pin', false)
        ->assertDontSee('data-membership-private', false);
});

it('saves separately keyed new membership rows without mixing their settings', function () {
    $organisations = Organisation::factory()->count(2)->create(['campaign_id' => 1]);

    $this->post(route('characters.store', [1]), [
        'name' => 'Guild envoy',
        'character_save_organisations' => 1,
        'organisations' => ['new_0' => $organisations[0]->id, 'new_2' => $organisations[1]->id],
        'organisation_roles' => ['new_0' => 'Envoy', 'new_2' => 'Former leader'],
        'organisation_statuses' => ['new_0' => 0, 'new_2' => 1],
        'organisation_pins' => ['new_0' => 3, 'new_2' => ''],
        'organisation_privates' => ['new_0' => 1, 'new_2' => 0],
    ])->assertRedirect()->assertSessionHasNoErrors();

    $character = Character::whereHas('entity', fn ($query) => $query->where('name', 'Guild envoy'))->firstOrFail();
    $memberships = $character->organisationMemberships()->orderBy('id')->get();
    expect($memberships)->toHaveCount(2)
        ->and($memberships[0]->organisation_id)->toBe($organisations[0]->id)
        ->and($memberships[0]->role)->toBe('Envoy')
        ->and($memberships[0]->pin_id)->toBe(OrganisationMemberPin::both)
        ->and((bool) $memberships[0]->is_private)->toBeTrue()
        ->and($memberships[1]->organisation_id)->toBe($organisations[1]->id)
        ->and($memberships[1]->role)->toBe('Former leader')
        ->and($memberships[1]->status_id)->toBe(OrganisationMemberStatus::inactive)
        ->and((bool) $memberships[1]->is_private)->toBeFalse();
});

it('updates retained memberships and removes omitted memberships on save', function () {
    $character = Character::factory()->create(['campaign_id' => 1]);
    $organisations = Organisation::factory()->count(2)->create(['campaign_id' => 1]);
    $retained = $character->organisationMemberships()->create(['organisation_id' => $organisations[0]->id]);
    $removed = $character->organisationMemberships()->create(['organisation_id' => $organisations[1]->id]);

    $this->put(route('characters.update', [1, $character]), [
        'name' => $character->entity->name,
        'character_save_organisations' => 1,
        'organisations' => [$retained->id => $organisations[0]->id],
        'organisation_roles' => [$retained->id => 'Captain'],
        'organisation_statuses' => [$retained->id => 2],
        'organisation_pins' => [$retained->id => 1],
        'organisation_privates' => [$retained->id => 1],
    ])->assertRedirect()->assertSessionHasNoErrors();

    $retained->refresh();
    expect($retained->role)->toBe('Captain')
        ->and($retained->status_id)->toBe(OrganisationMemberStatus::unknown)
        ->and($retained->pin_id)->toBe(OrganisationMemberPin::character)
        ->and((bool) $retained->is_private)->toBeTrue();
    $this->assertModelMissing($removed);
});

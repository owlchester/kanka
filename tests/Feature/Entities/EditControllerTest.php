<?php

use App\Enums\CampaignVisibility;
use App\Http\Middleware\ReplicationSwitcher;
use App\Models\Character;
use App\Models\Entity;
use App\Models\EntityType;
use App\Models\Item;
use App\Models\ItemCreator;
use App\Models\Note;
use App\Models\Organisation;
use Illuminate\Support\Facades\DB;

it('pre-fills the privacy toggle as private when editing a private custom module entity', function () {
    $this->asUser()->withCampaign();

    $entityType = new EntityType([
        'code' => 'gadget',
        'is_special' => true,
        'is_enabled' => true,
    ]);
    $entityType->campaign_id = 1;
    $entityType->singular = 'Gadget';
    $entityType->plural = 'Gadgets';
    $entityType->icon = 'fa-solid fa-gear';
    $entityType->save();

    $entity = new Entity([
        'campaign_id' => 1,
        'entity_id' => 0,
        'name' => 'Secret Gadget',
        'is_private' => true,
    ]);
    $entity->type_id = $entityType->id;
    $entity->save();

    $this->get(route('entities.edit', [1, $entity]))
        ->assertSuccessful()
        ->assertSee('private: true', false);
});

it('forbids unauthenticated entity saves before resolving validation rules', function () {
    $this->asUser()->withCampaign([
        'visibility_id' => CampaignVisibility::public->value,
    ])->withNotes();

    $entity = Note::firstOrFail()->entity;
    auth()->guard('api')->forgetUser();

    $this->withoutMiddleware(ReplicationSwitcher::class);

    $this->patch(route('entities.update', [1, $entity]), [
        'name' => 'Updated Note',
    ])->assertForbidden();

    expect($entity->fresh()->name)->not->toBe('Updated Note');
});

it('renders an item edit form when a creator entity has been deleted', function () {
    $this->asUser()->withCampaign();

    $item = Item::factory()->create(['campaign_id' => 1]);
    $creator = Organisation::factory()->create(['campaign_id' => 1]);
    ItemCreator::create([
        'item_id' => $item->id,
        'creator_id' => $creator->entity->id,
    ]);
    $creator->entity->delete();

    $this->get(route('entities.edit', [1, $item->entity]))
        ->assertSuccessful();
});

it('renders an organisation edit form when a member entity has been deleted', function () {
    $this->asUser()->withCampaign();

    $organisation = Organisation::factory()->create(['campaign_id' => 1]);
    $character = Character::factory()->create(['campaign_id' => 1]);
    $organisation->members()->create(['character_id' => $character->id]);
    $character->entity->delete();

    $this->get(route('entities.edit', [1, $organisation->entity]))
        ->assertSuccessful();
});

it('renders a character edit form when an organisation entity has been deleted', function () {
    $this->asUser()->withCampaign();

    $character = Character::factory()->create(['campaign_id' => 1]);
    $organisation = Organisation::factory()->create(['campaign_id' => 1]);
    $character->organisationMemberships()->create(['organisation_id' => $organisation->id]);
    $organisation->entity->delete();

    $this->get(route('entities.edit', [1, $character->entity]))
        ->assertSuccessful();
});

it('preserves an entity last modified date during a stealth edit', function () {
    $this->asUser()->withCampaign();

    $entityType = new EntityType([
        'code' => 'gadget',
        'is_special' => true,
        'is_enabled' => true,
    ]);
    $entityType->campaign_id = 1;
    $entityType->singular = 'Gadget';
    $entityType->plural = 'Gadgets';
    $entityType->icon = 'fa-solid fa-gear';
    $entityType->save();

    $entity = new Entity([
        'campaign_id' => 1,
        'entity_id' => 0,
        'name' => 'Secret Gadget',
    ]);
    $entity->type_id = $entityType->id;
    $entity->save();
    $originalUpdatedAt = now()->subHour()->startOfSecond();
    DB::table('entities')->where('id', $entity->id)->update([
        'updated_at' => $originalUpdatedAt,
        'updated_by' => 1,
    ]);
    $entity->refresh();

    $this->patch(route('entities.update', [1, $entity]), [
        'name' => 'Updated Gadget',
        'stealth' => 1,
    ])->assertRedirect();

    $entity->refresh();

    expect($entity->name)->toBe('Updated Gadget')
        ->and($entity->updated_at->equalTo($originalUpdatedAt))->toBeTrue()
        ->and($entity->updated_by)->toBe(1);
});

it('preserves an entity last modified date when stealth editing its description', function () {
    $this->asUser()->withCampaign()->withCharacters();

    $entity = Entity::findOrFail(1);
    $originalUpdatedAt = now()->subHour()->startOfSecond();
    DB::table('entities')->where('id', $entity->id)->update([
        'updated_at' => $originalUpdatedAt,
        'updated_by' => 1,
    ]);
    $entity->refresh();

    $this->patch(route('entities.entry.update', [1, $entity]), [
        'entry' => 'A corrected description.',
        'stealth' => 1,
    ])->assertRedirect();

    $entity->refresh();

    expect($entity->entry)->toBe('<p>A corrected description.</p>')
        ->and($entity->updated_at->equalTo($originalUpdatedAt))->toBeTrue()
        ->and($entity->updated_by)->toBe(1);
});

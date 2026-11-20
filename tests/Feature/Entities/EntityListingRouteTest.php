<?php

use App\Models\Bookmark;
use App\Models\Campaign;
use App\Models\Character;
use App\Models\Entity;
use App\Models\EntityType;
use App\Models\Note;
use App\Models\Relation;

it('redirects bookmark entity listings to the bookmarks page', function () {
    $this->asUser()->withCampaign();

    $campaign = Campaign::firstOrFail();
    $entityType = EntityType::findOrFail(config('entities.ids.bookmark'));
    $bookmarksUrl = route('bookmarks.index', $campaign);

    $this->get(route('entities.index', [$campaign, $entityType]))
        ->assertRedirect($bookmarksUrl);

    $this->get(route('entities.index-api', [$campaign, $entityType]))
        ->assertRedirect($bookmarksUrl);
});

it('preserves legacy listing and child URLs and delegates legacy updates', function () {
    $this->asUser()->withCampaign();
    $campaign = Campaign::findOrFail(1);
    $note = Note::factory()->create(['campaign_id' => 1, 'name' => 'Original']);
    $entity = $note->entity;

    $this->get(route('notes.index', [1, 'page' => 2]))
        ->assertRedirect(route('entities.index', [$campaign, $entity->entityType, 'page' => 2]));
    $this->get(route('notes.show', [1, $note]))
        ->assertRedirect(route('entities.show', [$campaign, $entity]));
    $this->get(route('notes.edit', [1, $note, 'tab' => 'form-entry']))
        ->assertRedirect(route('entities.edit', [$campaign, $entity, 'tab' => 'form-entry']));

    $this->withHeader('X-Requested-With', 'XMLHttpRequest')
        ->patchJson(route('notes.update', [1, $note]), ['name' => 'Preflight'])
        ->assertOk()
        ->assertExactJson(['success' => true]);
    expect($entity->fresh()->name)->toBe('Original');
    $this->flushHeaders();

    $this->put(route('notes.update', [1, $note]), ['name' => 'Updated'])
        ->assertRedirect(route('entities.show', [$campaign, $entity]));
    expect($entity->fresh()->name)->toBe('Updated');

    $this->delete(route('notes.destroy', [1, $note]))->assertNotFound();
    $this->assertModelExists($entity);
});

it('creates a standard entity and its child through the unified form', function () {
    $this->asUser()->withCampaign();
    $campaign = Campaign::findOrFail(1);
    $type = EntityType::findOrFail(config('entities.ids.note'));

    $this->get(route('entities.create', [1, $type]))
        ->assertOk()
        ->assertSee(route('entities.store', [$campaign, $type]));
    $this->post(route('entities.store', [1, $type]), ['name' => 'Unified note'])
        ->assertRedirect();

    expect(Note::query()->sole()->entity->name)->toBe('Unified note');
});

it('does not resolve a legacy child ID from a different campaign', function () {
    $this->asUser()->withCampaign()->withCampaigns();
    $note = Note::factory()->create(['campaign_id' => 2, 'name' => 'Other campaign']);

    $this->get(route('notes.show', [1, $note]))->assertNotFound();
    $this->put(route('notes.update', [1, $note]), ['name' => 'Changed'])->assertNotFound();
    expect($note->entity->fresh()->name)->toBe('Other campaign');
});

it('still lists, creates and edits bookmarks outside entity CRUD', function () {
    $this->asUser()->withCampaign();
    $campaign = Campaign::findOrFail(1);
    $target = Note::factory()->create(['campaign_id' => 1])->entity;

    $this->get(route('bookmarks.create', $campaign))->assertOk();
    $this->post(route('bookmarks.store', $campaign), [
        'name' => 'My bookmark',
        'entity_id' => $target->id,
        'submit-update' => true,
    ])->assertSessionHasNoErrors();

    $bookmark = Bookmark::where('name', 'My bookmark')->sole();
    $this->get(route('bookmarks.edit', [$campaign, $bookmark]))->assertOk()->assertSee('My bookmark');
    $this->get(route('bookmarks.index', $campaign))->assertOk()->assertSee('My bookmark');

    $this->put(route('bookmarks.update', [$campaign, $bookmark]), [
        'name' => 'Updated bookmark',
        'submit-close' => true,
    ])->assertRedirect(route('bookmarks.index', $campaign));
});

it('still renders the campaign-wide relations table', function () {
    $this->asUser()->withCampaign()->withCharacters()->withRelations(['relation' => 'Visible relation']);

    $characters = Character::query()->orderBy('id')->get();
    Relation::factory()->create([
        'campaign_id' => 1,
        'owner_id' => $characters[2]->entity->id,
        'target_id' => $characters[3]->entity->id,
        'relation' => 'Unarchived relation',
    ]);
    Entity::query()->whereKey($characters[0]->entity->id)->update(['archived_at' => now()]);

    $this->get(route('relations.index', Campaign::findOrFail(1)))
        ->assertOk()
        ->assertSee('Unarchived relation')
        ->assertDontSee('Visible relation');
});

it('redirects relation creation to the edit route when requested', function () {
    $this->asUser()->withCampaign()->withCharacters();
    $campaign = Campaign::findOrFail(1);
    $characters = Character::query()->orderBy('id')->get();

    $response = $this->post(route('relations.store', $campaign), [
        'owner_id' => $characters[0]->entity->id,
        'target_id' => $characters[1]->entity->id,
        'relation' => 'Created relation',
        'submit-update' => true,
    ]);

    $response->assertRedirect();
    $relation = Relation::query()->where('relation', 'Created relation')->sole();
    $response->assertRedirect(route('relations.edit', [$campaign, $relation]));
});

<?php

use App\Models\CategoryStatus;
use App\Models\Character;
use App\Models\Entity;
use App\Models\EntityType;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

it('GETS all entities')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withCreatures()
    ->get('/api/1.0/campaigns/1/entities')
    ->assertStatus(200);

it('GETS a specific entity')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withCreatures()
    ->get('/api/1.0/campaigns/1/entities/1')
    ->assertStatus(200);

it('GETS all creatures')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withCreatures()
    ->get('/api/1.0/campaigns/1/entities?types=creature')
    ->assertStatus(200)
    ->assertJsonCount(5, 'data');

it('Transforms entities')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->postJson('/api/1.0/campaigns/1/transform', [
        'entities' => [1, 2, 3],
        'entity_type' => 4,
    ])
    ->assertJsonFragment(['success' => 'Succesfully transformed 3 entities.'])
    ->assertStatus(200);

it('POSTS a new character with a mention and checks that a new entity is created', function () {
    $this->asUser()
        ->withCampaign();

    $response = $this->postJson('/api/1.0/campaigns/1/characters', [
        'name' => fake()->name(),
        'entry' => '[new:item|Mega sword]',
    ]);
    $this->assertStringStartsWith('<p><a href="', json_decode($response->content(), true)['data']['entry_parsed']);
});

it('Transfers entities')
    ->asUser()
    ->withCampaign()
    ->withCampaigns(['created_by' => 1])
    ->withCharacters()
    ->postJson('/api/1.0/campaigns/1/transfer', [
        'entities' => [1, 2, 3],
        'campaign_id' => 2,
    ])
    ->assertStatus(200)
    ->assertJsonFragment(['success' => 'Succesfully transfered 3 entities.']);

it('Copies entities')
    ->asUser()
    ->withCampaign()
    ->withCampaigns(['created_by' => 1])
    ->withCharacters()
    ->postJson('/api/1.0/campaigns/1/transfer', [
        'entities' => [1, 2, 3],
        'campaign_id' => 2,
        'copy' => true,
    ])
    ->assertStatus(200)
    ->assertJsonFragment(['success' => 'Succesfully copied 3 entities.']);

it('only shows global and current campaign statuses in entity and bulk forms', function () {
    $this->asUser()->withCampaign()->withCampaigns()->withCharacters();

    $entityType = EntityType::findOrFail(config('entities.ids.character'));
    $globalStatus = CategoryStatus::create([
        'category_id' => $entityType->id,
        'key' => 'global',
    ]);
    $campaignStatus = CategoryStatus::create([
        'campaign_id' => 1,
        'category_id' => $entityType->id,
        'key' => 'campaign',
    ]);
    $otherStatus = CategoryStatus::create([
        'campaign_id' => 2,
        'category_id' => $entityType->id,
        'key' => 'other',
    ]);

    $forms = [
        $this->get(route('characters.create', [1])),
        $this->get(route('entities.edit', [1, Character::firstOrFail()->entity])),
        $this->get(route('bulk.batch', [1, $entityType]) . '?entities[]=1'),
    ];

    foreach ($forms as $response) {
        $response->assertSuccessful();
        preg_match('/<select[^>]*name="status_id"[^>]*>(.*?)<\/select>/s', $response->content(), $matches);

        expect($matches)->not->toBeEmpty();
        $statusSelect = $matches[1];
        expect($statusSelect)
            ->toContain('value="' . $globalStatus->id . '"')
            ->toContain('value="' . $campaignStatus->id . '"')
            ->not->toContain('value="' . $otherStatus->id . '"');
    }
});

it('clears a custom status when moving an entity to another campaign', function () {
    $this->asUser()->withCampaign()->withCampaigns()->withCharacters();

    $entityType = EntityType::findOrFail(config('entities.ids.character'));
    $status = CategoryStatus::create([
        'campaign_id' => 1,
        'category_id' => $entityType->id,
        'key' => 'custom',
    ]);
    $entity = Character::firstOrFail()->entity;
    $entity->updateQuietly(['status_id' => $status->id]);

    $this->postJson('/api/1.0/campaigns/1/transfer', [
        'entities' => [$entity->id],
        'campaign_id' => 2,
    ])->assertSuccessful();

    expect($entity->fresh()->campaign_id)->toBe(2)
        ->and($entity->fresh()->status_id)->toBeNull();
});

it('clears a custom status when copying an entity to another campaign', function () {
    $this->asUser()->withCampaign()->withCampaigns()->withCharacters();

    $entityType = EntityType::findOrFail(config('entities.ids.character'));
    $status = CategoryStatus::create([
        'campaign_id' => 1,
        'category_id' => $entityType->id,
        'key' => 'custom',
    ]);
    $entity = Character::firstOrFail()->entity;
    $entity->updateQuietly(['status_id' => $status->id]);

    $this->postJson('/api/1.0/campaigns/1/transfer', [
        'entities' => [$entity->id],
        'campaign_id' => 2,
        'copy' => true,
    ])->assertSuccessful();

    $copy = Entity::withoutGlobalScopes()
        ->where('campaign_id', 2)
        ->where('name', $entity->name)
        ->firstOrFail();

    expect($entity->fresh()->status_id)->toBe($status->id)
        ->and($copy->status_id)->toBeNull();
});

it('preserves a global status when moving and copying an entity to another campaign', function () {
    $this->asUser()->withCampaign()->withCampaigns()->withCharacters();

    $entityType = EntityType::findOrFail(config('entities.ids.character'));
    $status = CategoryStatus::create([
        'category_id' => $entityType->id,
        'key' => 'global',
    ]);
    $movingEntity = Character::firstOrFail()->entity;
    $movingEntity->updateQuietly(['status_id' => $status->id]);
    $copyingEntity = Character::skip(1)->firstOrFail()->entity;
    $copyingEntity->updateQuietly(['status_id' => $status->id]);

    $this->postJson('/api/1.0/campaigns/1/transfer', [
        'entities' => [$movingEntity->id],
        'campaign_id' => 2,
    ])->assertSuccessful();
    $this->postJson('/api/1.0/campaigns/1/transfer', [
        'entities' => [$copyingEntity->id],
        'campaign_id' => 2,
        'copy' => true,
    ])->assertSuccessful();

    $copy = Entity::withoutGlobalScopes()
        ->where('campaign_id', 2)
        ->where('name', $copyingEntity->name)
        ->firstOrFail();

    expect($movingEntity->fresh()->status_id)->toBe($status->id)
        ->and($copy->status_id)->toBe($status->id);
});

it('copies the entity gallery image and header to the target campaign', function () {
    $this->asUser()
        ->withCampaign()
        ->withCampaigns()
        ->withCharacters();

    config(['limits.gallery.standard' => 10]);
    Storage::fake();

    Image::factory()->create(['campaign_id' => 1, 'size' => 9]);
    $image = Image::factory()->create(['campaign_id' => 1, 'size' => 2]);
    $header = Image::factory()->create(['campaign_id' => 1, 'size' => 3]);
    Storage::put($image->path, 'image');
    Storage::put($header->path, 'header');

    $source = Character::findOrFail(1)->entity;
    $source->updateQuietly([
        'image_uuid' => $image->id,
        'header_uuid' => $header->id,
    ]);

    $this->postJson('/api/1.0/campaigns/1/transfer', [
        'entities' => [$source->id],
        'campaign_id' => 2,
        'copy' => true,
    ])->assertSuccessful();

    $copy = Entity::withoutGlobalScopes()
        ->where('campaign_id', 2)
        ->where('name', $source->name)
        ->firstOrFail();
    $copyImage = Image::withoutGlobalScopes()->findOrFail($copy->image_uuid);
    $copyHeader = Image::withoutGlobalScopes()->findOrFail($copy->header_uuid);

    expect($copy->image_path)->toBeNull()
        ->and($copy->header_image)->toBeNull()
        ->and($copyImage->id)->not->toBe($image->id)
        ->and($copyImage->campaign_id)->toBe(2)
        ->and($copyHeader->id)->not->toBe($header->id)
        ->and($copyHeader->campaign_id)->toBe(2);

    Storage::assertExists($image->path);
    Storage::assertExists($header->path);
    Storage::assertExists($copyImage->path);
    Storage::assertExists($copyHeader->path);
});

it('clears and deletes a legacy header image when moving an entity', function () {
    $this->asUser()
        ->withCampaign()
        ->withCampaigns()
        ->withCharacters();

    Storage::fake();
    $path = 'legacy/header.png';
    Storage::put($path, 'header');

    $source = Character::findOrFail(1)->entity;
    $source->updateQuietly(['header_image' => $path]);

    $this->postJson('/api/1.0/campaigns/1/transfer', [
        'entities' => [$source->id],
        'campaign_id' => 2,
    ])->assertSuccessful();

    expect(Entity::withoutGlobalScopes()->findOrFail($source->id)->header_image)->toBeNull();
    Storage::assertMissing($path);
});

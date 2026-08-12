<?php

use App\Models\Campaign;
use App\Models\CampaignDescription;
use App\Models\Character;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

function legacyDestination(int $campaignId, string $source): string
{
    $uuid = Uuid::uuid5(Uuid::NAMESPACE_URL, "kanka:legacy-image:{$campaignId}:{$source}")->toString();
    $extension = mb_strtolower(pathinfo($source, PATHINFO_EXTENSION));

    return "w/{$campaignId}/legacy/{$uuid}.{$extension}";
}

beforeEach(function () {
    $this->asUser()->withCampaign();
    config(['cdn.ugc' => 'https://cdn-ugc.kanka.io']);
});

it('migrates an owned legacy image and rewrites embedded references', function () {
    $source = 'characters/old/portrait.jpg';
    $character = Character::factory()->create(['campaign_id' => 1]);
    $entity = $character->entity;
    $entity->forceFill([
        'image_path' => $source,
        'entry' => '<img src="https://cdn-ugc.kanka.io/' . $source . '?v=1">',
        'tooltip' => '<a href="/' . $source . '">portrait</a>',
    ])->saveQuietly();
    $post = Post::factory()->create([
        'entity_id' => $entity->id,
        'entry' => '<img src="https://kanka-user-assets.s3.eu-central-1.amazonaws.com/' . $source . '">',
    ]);
    $description = CampaignDescription::create([
        'campaign_id' => 1,
        'description' => '<img src="' . $source . '">',
        'excerpt' => null,
    ]);
    Storage::disk('s3')->put($source, 'image-content');

    $this->artisan('images:migrate-legacy', ['prefix' => 'characters', '--execute' => true])
        ->assertSuccessful();

    $destination = legacyDestination(1, $source);
    Storage::disk('s3')->assertMissing($source);
    Storage::disk('s3')->assertExists($destination);
    expect($entity->fresh()->image_path)->toBe($destination)
        ->and($entity->fresh()->entry)->toContain('https://cdn-ugc.kanka.io/' . $destination . '?v=1')
        ->and($entity->fresh()->tooltip)->toContain('/' . $destination)
        ->and($post->fresh()->entry)->toContain('https://cdn-ugc.kanka.io/' . $destination)
        ->and($description->fresh()->description)->toContain($destination)
        ->and(DB::table('legacy_image_migrations')->where('source_hash', hash('sha256', $source))->value('status'))->toBe('complete');
});

it('uses the oldest entity as owner and rewrites cross-campaign consumers', function () {
    $source = 'characters/shared.png';
    $owner = Character::factory()->create(['campaign_id' => 1])->entity;
    $owner->forceFill(['image_path' => $source])->saveQuietly();

    $otherCampaign = Campaign::factory()->create();
    $consumer = Character::factory()->create(['campaign_id' => $otherCampaign->id])->entity;
    $consumer->forceFill([
        'image_path' => $source,
        'entry' => '<img src="https://cdn-ugc.kanka.io/' . $source . '">',
    ])->saveQuietly();
    Storage::disk('s3')->put($source, 'shared-content');

    $this->artisan('images:migrate-legacy', ['prefix' => 'characters', '--execute' => true])
        ->assertSuccessful();

    $destination = legacyDestination(1, $source);
    expect($owner->fresh()->image_path)->toBe($destination)
        ->and($consumer->fresh()->image_path)->toBe($destination)
        ->and($consumer->fresh()->entry)->toContain('https://cdn-ugc.kanka.io/' . $destination);
});

it('is a dry run unless execute is supplied', function () {
    $source = 'characters/dry-run.webp';
    $entity = Character::factory()->create(['campaign_id' => 1])->entity;
    $entity->forceFill(['image_path' => $source])->saveQuietly();
    Storage::disk('s3')->put($source, 'image-content');

    $this->artisan('images:migrate-legacy', ['prefix' => 'characters'])
        ->assertSuccessful();

    Storage::disk('s3')->assertExists($source);
    expect($entity->fresh()->image_path)->toBe($source)
        ->and(DB::table('legacy_image_migrations')->count())->toBe(0);
});

it('leaves the source and database untouched when an unresolved thumbor reference exists', function () {
    $source = 'characters/signed.jpg';
    $entity = Character::factory()->create(['campaign_id' => 1])->entity;
    $entity->forceFill([
        'image_path' => $source,
        'entry' => '<img src="https://th.kanka.io/signature/200x200/src/' . $source . '">',
    ])->saveQuietly();
    Storage::disk('s3')->put($source, 'image-content');

    $this->artisan('images:migrate-legacy', ['prefix' => 'characters', '--execute' => true])
        ->assertFailed();

    Storage::disk('s3')->assertExists($source);
    expect($entity->fresh()->image_path)->toBe($source)
        ->and($entity->fresh()->entry)->toContain($source);
});

it('continues with later objects when one source is missing', function () {
    $missing = 'characters/a-missing.jpg';
    $valid = 'characters/b-valid.jpg';
    $missingEntity = Character::factory()->create(['campaign_id' => 1])->entity;
    $missingEntity->forceFill(['image_path' => $missing])->saveQuietly();
    $validEntity = Character::factory()->create(['campaign_id' => 1])->entity;
    $validEntity->forceFill(['image_path' => $valid])->saveQuietly();
    Storage::disk('s3')->put($valid, 'valid-content');

    $this->artisan('images:migrate-legacy', ['prefix' => 'characters', '--execute' => true])
        ->assertFailed();

    expect($missingEntity->fresh()->image_path)->toBe($missing)
        ->and($validEntity->fresh()->image_path)->toBe(legacyDestination(1, $valid));
    Storage::disk('s3')->assertMissing($valid);
    Storage::disk('s3')->assertExists(legacyDestination(1, $valid));
});

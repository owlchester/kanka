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

    $this->artisan('images:migrate-legacy', ['prefix' => 'characters', '--index' => true])
        ->assertSuccessful();
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

    $this->artisan('images:migrate-legacy', ['prefix' => 'characters', '--index' => true])
        ->assertSuccessful();
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

    $this->artisan('images:migrate-legacy', ['prefix' => 'characters', '--index' => true])
        ->assertFailed();
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

    $this->artisan('images:migrate-legacy', ['prefix' => 'characters', '--index' => true])
        ->assertSuccessful();
    $this->artisan('images:migrate-legacy', ['prefix' => 'characters', '--execute' => true])
        ->assertFailed();

    expect($missingEntity->fresh()->image_path)->toBe($missing)
        ->and($validEntity->fresh()->image_path)->toBe(legacyDestination(1, $valid));
    Storage::disk('s3')->assertMissing($valid);
    Storage::disk('s3')->assertExists(legacyDestination(1, $valid));
});

it('indexes content once and execution uses only recorded references', function () {
    $source = 'sections/old.png';
    $entity = Character::factory()->create(['campaign_id' => 1])->entity;
    $entity->forceFill([
        'image_path' => $source,
        'entry' => '<img src="https://cdn-ugc.kanka.io/' . $source . '">',
    ])->saveQuietly();
    Storage::disk('s3')->put($source, 'image-content');

    $this->artisan('images:migrate-legacy', ['prefix' => 'sections', '--index' => true])
        ->assertSuccessful();

    expect(DB::table('legacy_image_migration_references')->count())->toBe(1);

    // A later unrelated prefix string was never indexed and must not be scanned during execution.
    $other = Character::factory()->create(['campaign_id' => 1])->entity;
    $other->forceFill(['entry' => '<p>sections/unowned.png</p>'])->saveQuietly();

    $this->artisan('images:migrate-legacy', ['prefix' => 'sections', '--execute' => true])
        ->assertSuccessful();

    expect($entity->fresh()->entry)->toContain(legacyDestination(1, $source))
        ->and($other->fresh()->entry)->toContain('sections/unowned.png');
});

it('rewrites multiple indexed images in one content row across bounded runs', function () {
    $first = 'characters/one.jpg';
    $second = 'characters/two.jpg';
    $firstEntity = Character::factory()->create(['campaign_id' => 1])->entity;
    $firstEntity->forceFill(['image_path' => $first])->saveQuietly();
    $secondEntity = Character::factory()->create(['campaign_id' => 1])->entity;
    $secondEntity->forceFill(['image_path' => $second])->saveQuietly();
    $post = Post::factory()->create([
        'entity_id' => $firstEntity->id,
        'entry' => '<img src="' . $first . '"><img src="' . $second . '">',
    ]);
    Storage::disk('s3')->put($first, 'first');
    Storage::disk('s3')->put($second, 'second');

    $this->artisan('images:migrate-legacy', ['prefix' => 'characters', '--index' => true])
        ->assertSuccessful();
    $this->artisan('images:migrate-legacy', ['prefix' => 'characters', '--limit' => 1, '--execute' => true])
        ->assertSuccessful();

    expect($post->fresh()->entry)->toContain(legacyDestination(1, $first))->toContain($second);

    $this->artisan('images:migrate-legacy', ['prefix' => 'characters', '--limit' => 1, '--execute' => true])
        ->assertSuccessful();

    expect($post->fresh()->entry)->toContain(legacyDestination(1, $first))
        ->toContain(legacyDestination(1, $second));
});

it('records content-only legacy paths as blockers', function () {
    $entity = Character::factory()->create(['campaign_id' => 1])->entity;
    $entity->forceFill(['entry' => '<img src="https://cdn-ugc.kanka.io/sections/unowned.jpg">'])->saveQuietly();

    $this->artisan('images:migrate-legacy', ['prefix' => 'sections', '--index' => true])
        ->assertFailed();

    expect(DB::table('legacy_image_migration_references')->where('status', 'blocker')->count())->toBe(1)
        ->and(DB::table('legacy_image_migration_indexes')->where('prefix', 'sections/')->value('blocker_count'))->toBe(1);
});

it('does not treat an external host path as an owned legacy reference', function () {
    $entity = Character::factory()->create(['campaign_id' => 1])->entity;
    $entity->forceFill(['entry' => '<img src="https://example.com/sections/external.jpg">'])->saveQuietly();

    $this->artisan('images:migrate-legacy', ['prefix' => 'sections', '--index' => true])
        ->assertFailed();

    expect(DB::table('legacy_image_migration_references')->where('status', 'blocker')->count())->toBe(1)
        ->and(DB::table('legacy_image_migrations')->count())->toBe(0);
});

it('blocks deletion when another structured field references the source', function () {
    $source = 'characters/header.jpg';
    $entity = Character::factory()->create(['campaign_id' => 1])->entity;
    $entity->forceFill([
        'image_path' => $source,
        'header_image' => $source,
    ])->saveQuietly();
    Storage::disk('s3')->put($source, 'image-content');

    $this->artisan('images:migrate-legacy', ['prefix' => 'characters', '--index' => true])
        ->assertFailed();
    $this->artisan('images:migrate-legacy', ['prefix' => 'characters', '--execute' => true])
        ->assertFailed();

    Storage::disk('s3')->assertExists($source);
    expect($entity->fresh()->image_path)->toBe($source)
        ->and(DB::table('legacy_image_migration_references')->where('status', 'blocker')->count())->toBe(1);
});

it('repairs references discovered after a completed migration through reindexing', function () {
    $source = 'characters/reindexed.jpg';
    $entity = Character::factory()->create(['campaign_id' => 1])->entity;
    $entity->forceFill(['image_path' => $source])->saveQuietly();
    Storage::disk('s3')->put($source, 'image-content');

    $this->artisan('images:migrate-legacy', ['prefix' => 'characters', '--index' => true])->assertSuccessful();
    $this->artisan('images:migrate-legacy', ['prefix' => 'characters', '--execute' => true])->assertSuccessful();

    $lateReference = Character::factory()->create(['campaign_id' => 1])->entity;
    $lateReference->forceFill(['entry' => '<img src="https://cdn-ugc.kanka.io/' . $source . '">'])->saveQuietly();

    $this->artisan('images:migrate-legacy', ['prefix' => 'characters', '--rebuild-index' => true])->assertSuccessful();
    $this->artisan('images:migrate-legacy', ['prefix' => 'characters', '--execute' => true])->assertSuccessful();

    expect($lateReference->fresh()->entry)->toContain(legacyDestination(1, $source));
});

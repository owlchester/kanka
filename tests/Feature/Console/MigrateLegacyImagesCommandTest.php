<?php

use App\Models\Campaign;
use App\Models\CampaignDescription;
use App\Models\Character;
use App\Models\Post;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

function legacyDestination(int $campaignId, string $source): string
{
    $uuid = Uuid::uuid5(Uuid::NAMESPACE_URL, "kanka:legacy-image:{$campaignId}:{$source}")->toString();
    $cleanSource = preg_split('/[?#]/', $source, 2)[0];
    $extension = mb_strtolower(pathinfo($cleanSource, PATHINFO_EXTENSION));

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
        ->assertSuccessful();

    expect(DB::table('legacy_image_migration_references')->where('status', 'blocker')->count())->toBe(0)
        ->and(DB::table('legacy_image_migrations')->count())->toBe(0);
});

it('ignores prefix-like prose that is not an image url', function () {
    $entity = Character::factory()->create(['campaign_id' => 1])->entity;
    $entity->forceFill([
        'entry' => '<p>mixings, dissections/autopsies and research of otherworld</p><p>See sections/history for details.</p>',
    ])->saveQuietly();

    $this->artisan('images:migrate-legacy', ['prefix' => 'sections', '--index' => true])
        ->assertSuccessful();

    expect(DB::table('legacy_image_migration_references')->count())->toBe(0);
});

it('recognizes relative paths only in url-bearing html attributes', function () {
    $entity = Character::factory()->create(['campaign_id' => 1])->entity;
    $entity->forceFill([
        'entry' => '<p>sections/plain-text.jpg</p><img src="/sections/image.jpg">',
    ])->saveQuietly();

    $this->artisan('images:migrate-legacy', ['prefix' => 'sections', '--index' => true])
        ->assertFailed();

    $reference = DB::table('legacy_image_migration_references')->where('status', 'blocker')->first();
    expect($reference)->not->toBeNull()
        ->and($reference->error)->toBe('No owning entity for sections/image.jpg');
});

it('indexes html attributes without a complete value capture', function () {
    $entity = Character::factory()->create(['campaign_id' => 1])->entity;
    $entity->forceFill([
        'entry' => '<img src=> <img data-src="/sections/image.jpg">',
    ])->saveQuietly();

    $this->artisan('images:migrate-legacy', ['prefix' => 'sections', '--rebuild-index' => true])
        ->assertFailed();

    expect(DB::table('legacy_image_migration_references')->where('status', 'blocker')->count())->toBe(1);
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

it('migrates literal legacy s3 keys containing url parameters to a clean destination', function () {
    $source = 'sections/5b2d40eb0d64a_dwarfking_colorbylee.jpg?w=851&h=1098&crop=1';
    $entity = Character::factory()->create(['campaign_id' => 1])->entity;
    $entity->forceFill([
        'image_path' => $source,
        'entry' => '<img src="https://cdn-ugc.kanka.io/' . $source . '">',
    ])->saveQuietly();
    Storage::disk('s3')->put($source, 'image-content');

    $this->artisan('images:migrate-legacy', ['prefix' => 'sections', '--index' => true])
        ->assertSuccessful();
    $this->artisan('images:migrate-legacy', ['prefix' => 'sections', '--execute' => true])
        ->assertSuccessful();

    $destination = legacyDestination(1, $source);
    expect($destination)->toEndWith('.jpg')->not->toContain('?')
        ->and($entity->fresh()->image_path)->toBe($destination)
        ->and($entity->fresh()->entry)->toContain('https://cdn-ugc.kanka.io/' . $destination)
        ->not->toContain('?w=851');
    Storage::disk('s3')->assertMissing($source);
    Storage::disk('s3')->assertExists($destination);
});

it('detects an extensionless query-bearing image from its bytes', function () {
    $source = 'sections/5b2d40eb0d64_dwarfking_colorbylee?cb=123';
    $entity = Character::factory()->create(['campaign_id' => 1])->entity;
    $entity->forceFill(['image_path' => $source])->saveQuietly();
    Storage::disk('s3')->put($source, "\xFF\xD8\xFF\xE0jpeg-content");

    $this->artisan('images:migrate-legacy', ['prefix' => 'sections', '--index' => true])
        ->assertSuccessful();

    $migration = DB::table('legacy_image_migrations')->where('source_path', $source)->first();
    expect($migration->detected_mime)->toBe('image/jpeg')
        ->and($migration->resolution_status)->toBe('resolved')
        ->and($migration->destination_path)->toEndWith('.jpg');

    $this->artisan('images:migrate-legacy', ['prefix' => 'sections', '--execute' => true])
        ->assertSuccessful();

    Storage::disk('s3')->assertMissing($source);
    Storage::disk('s3')->assertExists($migration->destination_path);
    expect($entity->fresh()->image_path)->toBe($migration->destination_path);
});

it('blocks extensionless objects whose image format cannot be identified', function () {
    $source = 'sections/unknown-image?cb=456';
    $entity = Character::factory()->create(['campaign_id' => 1])->entity;
    $entity->forceFill(['image_path' => $source])->saveQuietly();
    Storage::disk('s3')->put($source, 'not-an-image');

    $this->artisan('images:migrate-legacy', ['prefix' => 'sections', '--index' => true])
        ->assertFailed();

    $migration = DB::table('legacy_image_migrations')->where('source_path', $source)->first();
    expect($migration->status)->toBe('blocked')
        ->and($migration->resolution_status)->toBe('blocked')
        ->and($migration->destination_path)->toBeNull()
        ->and($migration->error)->toContain('Unable to identify image format');

    $this->artisan('images:migrate-legacy', ['prefix' => 'sections', '--execute' => true])
        ->assertFailed();

    Storage::disk('s3')->assertExists($source);
    expect($entity->fresh()->image_path)->toBe($source);
});

it('blocks extensionless objects when metadata conflicts with detected bytes', function () {
    $source = 'sections/conflicting-image?cb=789';
    $entity = Character::factory()->create(['campaign_id' => 1])->entity;
    $entity->forceFill(['image_path' => $source])->saveQuietly();
    $stream = fopen('data://text/plain,' . rawurlencode("\x89PNG\x0D\x0A\x1A\x0Apng-content"), 'rb');
    $disk = Mockery::mock(Filesystem::class);
    $disk->shouldReceive('exists')->with($source)->andReturnTrue();
    $disk->shouldReceive('mimeType')->with($source)->andReturn('image/jpeg');
    $disk->shouldReceive('readStream')->with($source)->andReturn($stream);
    Storage::shouldReceive('disk')->with('s3')->andReturn($disk);

    $this->artisan('images:migrate-legacy', ['prefix' => 'sections', '--index' => true])
        ->assertFailed();

    $migration = DB::table('legacy_image_migrations')->where('source_path', $source)->first();
    expect($migration->status)->toBe('blocked')
        ->and($migration->error)->toContain('conflicts with detected format');
});

it('resolves a clean content url to a unique query-bearing owner path', function () {
    $cleanSource = 'sections/legacy-image.jpg';
    $source = $cleanSource . '?w=800&h=600';
    $entity = Character::factory()->create(['campaign_id' => 1])->entity;
    $entity->forceFill([
        'image_path' => $source,
        'entry' => '<img src="https://cdn-ugc.kanka.io/' . $cleanSource . '">',
    ])->saveQuietly();
    Storage::disk('s3')->put($source, 'image-content');

    $this->artisan('images:migrate-legacy', ['prefix' => 'sections', '--index' => true])
        ->assertSuccessful();
    $this->artisan('images:migrate-legacy', ['prefix' => 'sections', '--execute' => true])
        ->assertSuccessful();

    $destination = legacyDestination(1, $source);
    expect($entity->fresh()->image_path)->toBe($destination)
        ->and($entity->fresh()->entry)->toContain($destination)
        ->not->toContain($cleanSource);
});

it('resumes the reference index migration after partial ddl execution', function () {
    Schema::table('legacy_image_migration_references', function (Blueprint $table) {
        $table->dropIndex('legacy_img_ref_migration_idx');
        $table->dropIndex('legacy_img_ref_prefix_idx');
        $table->dropIndex('legacy_img_ref_status_idx');
    });

    $migration = require database_path('migrations/2026_08_13_000000_add_reference_index_to_legacy_image_migrations.php');
    $migration->up();

    expect(Schema::hasIndex('legacy_image_migration_references', ['legacy_image_migration_id']))->toBeTrue()
        ->and(Schema::hasIndex('legacy_image_migration_references', ['prefix']))->toBeTrue()
        ->and(Schema::hasIndex('legacy_image_migration_references', ['status']))->toBeTrue()
        ->and(Schema::hasIndex('entities', ['image_path']))->toBeTrue()
        ->and(Schema::hasColumn('legacy_image_migrations', 'prefix'))->toBeTrue();
});

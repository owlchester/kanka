<?php

use App\Models\Character;
use App\Models\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $this->asUser()->withCampaign();
});

it('clears legacy paths for entities with gallery images within the limit', function () {
    $firstImage = Image::factory()->create(['campaign_id' => 1]);
    $secondImage = Image::factory()->create(['campaign_id' => 1]);
    $first = Character::factory()->create(['campaign_id' => 1])->entity;
    $second = Character::factory()->create(['campaign_id' => 1])->entity;

    $first->forceFill([
        'image_path' => 'legacy/first.jpg',
        'image_uuid' => $firstImage->id,
    ])->saveQuietly();
    $second->forceFill([
        'image_path' => 'legacy/second.jpg',
        'image_uuid' => $secondImage->id,
    ])->saveQuietly();
    Storage::disk('s3')->put('legacy/first.jpg', 'first');
    Storage::disk('s3')->put('legacy/second.jpg', 'second');

    $this->artisan('images:cleanup-legacy', ['--limit' => 1])
        ->expectsOutput('Cleared 1 legacy image(s).')
        ->assertSuccessful();

    expect($first->fresh()->image_path)->toBeNull()
        ->and($first->fresh()->image_uuid)->toBe($firstImage->id)
        ->and($second->fresh()->image_path)->toBe('legacy/second.jpg');
    Storage::disk('s3')->assertMissing('legacy/first.jpg');
    Storage::disk('s3')->assertExists('legacy/second.jpg');
});

it('updates entities in batches', function () {
    $image = Image::factory()->create(['campaign_id' => 1]);
    $entities = Character::factory()->count(2)->create(['campaign_id' => 1]);

    foreach ($entities as $index => $character) {
        $character->entity->forceFill([
            'image_path' => "legacy/batch-{$index}.jpg",
            'image_uuid' => $image->id,
        ])->saveQuietly();
        Storage::disk('s3')->put("legacy/batch-{$index}.jpg", 'image');
    }

    $updates = 0;
    DB::listen(function ($query) use (&$updates) {
        $sql = mb_strtolower($query->sql);
        if (str_contains($sql, 'update') && str_contains($sql, 'entities')) {
            $updates++;
        }
    });

    $this->artisan('images:cleanup-legacy')
        ->expectsOutput('Cleared 2 legacy image(s).')
        ->assertSuccessful();

    expect($updates)->toBe(1);
});

it('ignores entities without a gallery image UUID', function () {
    $entity = Character::factory()->create(['campaign_id' => 1])->entity;
    $entity->forceFill(['image_path' => 'legacy/no-gallery.jpg'])->saveQuietly();
    Storage::disk('s3')->put('legacy/no-gallery.jpg', 'image');

    $this->artisan('images:cleanup-legacy')
        ->expectsOutput('Cleared 0 legacy image(s).')
        ->assertSuccessful();

    expect($entity->fresh()->image_path)->toBe('legacy/no-gallery.jpg');
    Storage::disk('s3')->assertExists('legacy/no-gallery.jpg');
});

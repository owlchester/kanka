<?php

use App\Enums\EntityAssetType;
use App\Enums\Visibility;
use App\Facades\CampaignLocalization;
use App\Models\Campaign;
use App\Models\CampaignPermission;
use App\Models\Character;
use App\Models\EntityAsset;
use App\Models\Image;
use App\Services\Submenus\SubmenuService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Number;

it('POSTS an invalid entity_assets form')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->postJson('/api/1.0/campaigns/1/entities/1/entity_assets', [])
    ->assertStatus(422);

it('does not POST an entity_asset with an invalid type')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->postJson('/api/1.0/campaigns/1/entities/1/entity_assets', [
        'name' => fake()->name(),
        'type_id' => 0,
        'visibility_id' => 1,
    ])
    ->assertStatus(422);

it('POSTS a new Alias')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->postJson('/api/1.0/campaigns/1/entities/1/entity_assets', [
        'name' => fake()->name(),
        'entity_id' => 1,
        'type_id' => 3,
        'visibility_id' => 1,
    ])
    ->assertStatus(201)
    ->assertJsonStructure([
        'data' => [
            'id',
            'entity_id',
        ],
    ]);

it('POSTS a new File')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->postJson('/api/1.0/campaigns/1/entities/1/entity_assets', [
        'name' => fake()->name(),
        // 'entity_id' => 1,
        'type_id' => 1,
        'visibility_id' => 1,
        'file' => UploadedFile::fake()->image('avatar.jpg'),
    ])
    ->assertStatus(201)
    ->assertJsonStructure([
        'data' => [
            'id',
            'entity_id',
        ],
    ]);

it('returns a translated error when the entity file limit is reached', function () {
    $this->asUser()->withCampaign()->withCharacters();
    config(['limits.campaigns.files.standard' => 0]);

    $assetCount = EntityAsset::count();
    $imageCount = Image::count();

    $this->postJson('/api/1.0/campaigns/1/entities/1/entity_assets', [
        'type_id' => EntityAssetType::file->value,
        'visibility_id' => 1,
        'file' => UploadedFile::fake()->image('avatar.jpg'),
    ])
        ->assertUnprocessable()
        ->assertJsonPath('error', __('crud.files.errors.max', ['max' => 0]));

    expect(EntityAsset::count())->toBe($assetCount)
        ->and(Image::count())->toBe($imageCount);
});

it('returns a translated error when gallery storage is exhausted', function (bool $premium, string $errorKey) {
    $this->asUser()->withCampaign($premium ? ['boost_count' => 4] : [])->withCharacters();
    config([
        $premium ? 'limits.gallery.premium' : 'limits.gallery.standard' => 1,
    ]);
    Image::factory()->create(['campaign_id' => 1, 'size' => 2]);
    Cache::forget('campaign_1_gallery');

    $assetCount = EntityAsset::count();
    $imageCount = Image::count();

    $this->postJson('/api/1.0/campaigns/1/entities/1/entity_assets', [
        'type_id' => EntityAssetType::file->value,
        'visibility_id' => 1,
        'file' => UploadedFile::fake()->image('avatar.jpg'),
    ])
        ->assertUnprocessable()
        ->assertJsonPath('error', __($errorKey));

    expect(EntityAsset::count())->toBe($assetCount)
        ->and(Image::count())->toBe($imageCount)
        ->and(Storage::disk('s3')->allFiles())->toBe([]);
})->with([
    'free gallery' => [false, 'gallery.download.errors.gallery_full_free'],
    'premium gallery' => [true, 'gallery.download.errors.gallery_full_premium'],
]);

it('POSTS a new Link')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->postJson('/api/1.0/campaigns/1/entities/1/entity_assets', [
        'name' => fake()->name(),
        'entity_id' => 1,
        'type_id' => 2,
        'visibility_id' => 1,
        'metadata' => [
            'url' => 'https://www.google.com',
            'icon' => 'fa-solid fa-towers',
        ],
    ])
    ->assertStatus(201)
    ->assertJsonStructure([
        'data' => [
            'id',
            'entity_id',
        ],
    ]);

it('GETS all entity_assets')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withAssets()
    ->get('/api/1.0/campaigns/1/entities/1/entity_assets')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            [
                'id',
                'entity_id',
                'name',
                'is_private',
            ],
        ],
    ]);

it('GETS a specific asset')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withAssets()
    ->get('/api/1.0/campaigns/1/entities/1/entity_assets/1')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            'id',
            'name',
            'is_private',
        ],
    ]);

it('GETS legacy entity_assets with an invalid type without crashing', function () {
    $this->asUser()->withCampaign()->withCharacters();

    DB::table('entity_assets')->insert([
        'entity_id' => 1,
        'type_id' => 0,
        'name' => 'Legacy asset',
        'metadata' => '{}',
        'visibility_id' => 1,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $this->get('/api/1.0/campaigns/1/entities/1/entity_assets')
        ->assertStatus(200)
        ->assertJsonFragment([
            'type_id' => null,
            '_file' => false,
            '_link' => false,
            '_alias' => false,
        ]);
});

it('UPDATES a valid asset')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withAssets()
    ->putJson('/api/1.0/campaigns/1/entities/1/entity_assets/1', ['name' => 'Bob'])
    ->assertStatus(200)
    ->assertJsonFragment(['name' => 'Bob']);

it('includes the asset type when editing a file', function () {
    $this->asUser()
        ->withCampaign()
        ->withCharacters();

    EntityAsset::factory()->create([
        'entity_id' => 1,
        'type_id' => EntityAssetType::file,
    ]);

    $this->get(route('entities.entity_assets.edit', [1, 1, 1]))
        ->assertSuccessful()
        ->assertSee('<input type="hidden" name="type_id" value="1" />', false);
});

it('updates a file without requiring a replacement upload', function () {
    $this->asUser()
        ->withCampaign()
        ->withCharacters();

    $asset = EntityAsset::factory()->create([
        'entity_id' => 1,
        'type_id' => EntityAssetType::file,
    ]);
    $entity = $asset->entity;
    $campaign = $entity->campaign;

    $this->patch(route('entities.entity_assets.update', [$campaign, $entity, $asset]), [
        'type_id' => EntityAssetType::file->value,
        'name' => 'Renamed file',
    ])->assertRedirect(route('entities.entity_assets.index', [$campaign, $entity]));

    expect($asset->refresh()->name)->toBe('Renamed file');
});

it('DELETES an asset')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withAssets()
    ->delete('/api/1.0/campaigns/1/entities/1/entity_assets/1')
    ->assertStatus(204);

it('DELETES an invalid asset')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withAssets()
    ->delete('/api/1.0/campaigns/1/entities/1/entity_assets/100')
    ->assertStatus(404);

it('shows the action empty state on the assets subpage for editors', function () {
    $this->asUser()->withCampaign();
    $campaign = Campaign::findOrFail(1);
    $character = Character::factory()->create(['campaign_id' => $campaign->id]);

    $this->get(route('entities.entity_assets.index', [$campaign, $character->entity]))
        ->assertOk()
        ->assertSee('entity-empty-state')
        ->assertSee(__('entities/assets.empty.title', ['name' => $character->entity->name]))
        ->assertSee(__('entities/assets.empty.file.title'))
        ->assertSee(__('entities/assets.empty.link.title'))
        ->assertDontSee(__('entities/assets.empty.read_only'));
});

it('shows the read-only empty state on the assets subpage for non-editors', function () {
    $this->asUser()->withCampaign();
    $campaign = Campaign::findOrFail(1);
    $character = Character::factory()->create(['campaign_id' => $campaign->id]);

    CampaignPermission::create([
        'campaign_id' => $campaign->id,
        'campaign_role_id' => 3,
        'entity_type_id' => config('entities.ids.character'),
        'action' => CampaignPermission::ACTION_READ,
        'access' => true,
    ]);
    $this->asPlayer();

    $this->get(route('entities.entity_assets.index', [$campaign, $character->entity]))
        ->assertOk()
        ->assertSee('entity-empty-state')
        ->assertSee(__('entities/assets.empty.read_only'))
        ->assertDontSee(__('entities/assets.empty.file.title'))
        ->assertDontSee(__('entities/assets.empty.link.title'));
});

it('shows the empty state when the only asset points to a hidden or missing gallery image', function () {
    $this->asUser()->withCampaign();
    $campaign = Campaign::findOrFail(1);
    $character = Character::factory()->create(['campaign_id' => $campaign->id]);

    EntityAsset::factory()->create([
        'entity_id' => $character->entity->id,
        'type_id' => EntityAssetType::file,
        'image_uuid' => '00000000-0000-0000-0000-000000000000',
        'metadata' => ['type' => 'image/png', 'path' => 'missing.png'],
    ]);

    $this->get(route('entities.entity_assets.index', [$campaign, $character->entity]))
        ->assertOk()
        ->assertSee('entity-empty-state')
        ->assertDontSee('entity-assets-row');
});

it('renders square preview cards, metadata, audio player, and external links on the assets subpage', function () {
    $this->asUser()->withCampaign();
    $campaign = Campaign::findOrFail(1);
    $character = Character::factory()->create(['campaign_id' => $campaign->id]);

    $image = Image::factory()->create([
        'campaign_id' => $campaign->id,
        'ext' => 'png',
        'size' => 256,
    ]);

    $imageAsset = EntityAsset::factory()->create([
        'entity_id' => $character->entity->id,
        'type_id' => EntityAssetType::file,
        'name' => 'Character Portrait',
        'is_pinned' => 1,
        'image_uuid' => $image->id,
        'metadata' => [
            'type' => 'image/png',
            'size' => 524288,
        ],
    ]);

    EntityAsset::factory()->create([
        'entity_id' => $character->entity->id,
        'type_id' => EntityAssetType::file,
        'name' => 'Tavern Theme',
        'metadata' => [
            'type' => 'audio/mpeg',
            'path' => 'audio/tavern.mp3',
            'size' => 1048576,
        ],
    ]);

    EntityAsset::factory()->create([
        'entity_id' => $character->entity->id,
        'type_id' => EntityAssetType::link,
        'name' => 'Sheet Link',
        'metadata' => [
            'url' => 'https://example.com/characters/1',
            'icon' => 'fa-solid fa-scroll',
        ],
    ]);

    $this->get(route('entities.entity_assets.index', [$campaign, $character->entity]))
        ->assertOk()
        ->assertDontSee('entity-empty-state')
        ->assertSee('aspect-square', false)
        ->assertSee($imageAsset->imageUrl(), false)
        ->assertSee('fa-regular fa-thumbtack', false)
        ->assertSee(Number::fileSize(524288))
        ->assertSee('<audio', false)
        ->assertSee('example.com');
});

it('uses the uploaded file visibility for its backing gallery image regardless of campaign default gallery visibility', function () {
    Storage::fake('s3');
    $this->asUser()->withCampaign();
    $campaign = Campaign::findOrFail(1);
    $campaign->settings = array_merge($campaign->settings ?? [], ['gallery_visibility' => 'admin']);
    $campaign->save();

    $character = Character::factory()->create(['campaign_id' => $campaign->id]);

    $this->post(route('entities.entity_assets.store', [$campaign, $character->entity]), [
        'type_id' => EntityAssetType::file->value,
        'visibility_id' => Visibility::All->value,
        'is_pinned' => 1,
        'files' => [UploadedFile::fake()->create('theme.mp3', 100, 'audio/mpeg')],
    ])->assertRedirect(route('entities.entity_assets.index', [$campaign, $character->entity]));

    $publicAsset = EntityAsset::query()
        ->where('entity_id', $character->entity->id)
        ->latest('id')
        ->firstOrFail();

    expect($publicAsset->visibility_id)->toBe(Visibility::All)
        ->and($publicAsset->image)->not->toBeNull()
        ->and($publicAsset->image->visibility_id)->toBe(Visibility::All);

    $this->post(route('entities.entity_assets.store', [$campaign, $character->entity]), [
        'type_id' => EntityAssetType::file->value,
        'visibility_id' => Visibility::Admin->value,
        'is_pinned' => 1,
        'files' => [UploadedFile::fake()->create('secret.mp3', 100, 'audio/mpeg')],
    ])->assertRedirect(route('entities.entity_assets.index', [$campaign, $character->entity]));

    $adminAsset = EntityAsset::query()
        ->where('entity_id', $character->entity->id)
        ->latest('id')
        ->firstOrFail();

    expect($adminAsset->visibility_id)->toBe(Visibility::Admin)
        ->and($adminAsset->image)->not->toBeNull()
        ->and($adminAsset->image->visibility_id)->toBe(Visibility::Admin);
});

it('excludes assets with hidden or missing gallery images from the media submenu count', function () {
    $this->asUser()->withCampaign();
    $campaign = Campaign::findOrFail(1);
    $character = Character::factory()->create(['campaign_id' => $campaign->id]);

    CampaignPermission::create([
        'campaign_id' => $campaign->id,
        'campaign_role_id' => 3,
        'entity_type_id' => config('entities.ids.character'),
        'action' => CampaignPermission::ACTION_READ,
        'access' => true,
    ]);

    $adminImage = Image::factory()->create([
        'campaign_id' => $campaign->id,
        'ext' => 'mp3',
        'visibility_id' => Visibility::Admin,
    ]);

    EntityAsset::factory()->create([
        'entity_id' => $character->entity->id,
        'type_id' => EntityAssetType::file,
        'visibility_id' => Visibility::All,
        'image_uuid' => $adminImage->id,
        'metadata' => ['type' => 'audio/mpeg'],
    ]);

    EntityAsset::factory()->create([
        'entity_id' => $character->entity->id,
        'type_id' => EntityAssetType::file,
        'visibility_id' => Visibility::All,
        'image_uuid' => '00000000-0000-0000-0000-000000000000',
        'metadata' => ['type' => 'audio/mpeg'],
    ]);

    CampaignLocalization::forceCampaign($campaign);

    // VisibilityIDScope intentionally skips console requests; exercise its web behaviour.
    $console = new ReflectionProperty(app(), 'isRunningInConsole');
    $console->setValue(app(), false);

    try {
        $adminItems = app(SubmenuService::class)
            ->campaign($campaign)
            ->entity($character->entity)
            ->user(auth()->user())
            ->items();

        $adminMediaCount = collect($adminItems)->collapse()->get('assets')['count'] ?? null;
        expect($adminMediaCount)->toBe(1);

        $this->asPlayer();

        $playerItems = app(SubmenuService::class)
            ->campaign($campaign)
            ->entity($character->entity)
            ->user(auth()->user())
            ->items();

        $playerMediaCount = collect($playerItems)->collapse()->get('assets')['count'] ?? null;
        expect($playerMediaCount)->toBe(0);

        $publicImage = Image::factory()->create([
            'campaign_id' => $campaign->id,
            'ext' => 'mp3',
            'visibility_id' => Visibility::All,
        ]);

        EntityAsset::factory()->create([
            'entity_id' => $character->entity->id,
            'type_id' => EntityAssetType::file,
            'visibility_id' => Visibility::All,
            'image_uuid' => $publicImage->id,
            'metadata' => ['type' => 'audio/mpeg'],
        ]);

        EntityAsset::factory()->create([
            'entity_id' => $character->entity->id,
            'type_id' => EntityAssetType::link,
            'visibility_id' => Visibility::All,
            'image_uuid' => null,
            'metadata' => ['url' => 'https://example.com'],
        ]);

        $playerItemsWithVisible = app(SubmenuService::class)
            ->campaign($campaign)
            ->entity($character->entity)
            ->user(auth()->user())
            ->items();

        $playerMediaCountWithVisible = collect($playerItemsWithVisible)->collapse()->get('assets')['count'] ?? null;
        expect($playerMediaCountWithVisible)->toBe(2);
    } finally {
        $console->setValue(app(), true);
    }
});

<?php

use App\Models\Campaign;
use App\Models\Character;
use App\Models\Image;
use App\Services\Images\Avatar;
use App\Services\Search\EntitySearchService;
use App\Services\Search\NameLookupService;

beforeEach(function () {
    $this->asUser()->withCampaign();
    $this->campaign = Campaign::findOrFail(1);
    config(['scout.search_maintenance' => false]);
});

it('returns entity images for full-text command search results', function () {
    $galleryImage = Image::factory()->create([
        'campaign_id' => $this->campaign->id,
    ]);

    $galleryCharacter = Character::factory()->create([
        'campaign_id' => $this->campaign->id,
        'name' => 'Gallery Avatar Character',
    ]);
    $galleryEntity = $galleryCharacter->entity;
    $galleryEntity->image_uuid = $galleryImage->id;
    $galleryEntity->saveQuietly();

    $legacyCharacter = Character::factory()->create([
        'campaign_id' => $this->campaign->id,
        'name' => 'Legacy Avatar Character',
    ]);
    $legacyEntity = $legacyCharacter->entity;
    $legacyEntity->image_path = 'entities/test-avatar.png';
    $legacyEntity->focus_x = 25;
    $legacyEntity->focus_y = 75;
    $legacyEntity->saveQuietly();

    $fallbackCharacter = Character::factory()->create([
        'campaign_id' => $this->campaign->id,
        'name' => 'Fallback Avatar Character',
    ]);
    $fallbackEntity = $fallbackCharacter->entity;

    $hits = [
        [
            'id' => 'character_' . $galleryEntity->id,
            'entity_id' => $galleryEntity->id,
            'type' => 'character',
            '_formatted' => ['entry' => 'Gallery <mark>avatar</mark> match'],
        ],
        [
            'id' => 'character_' . $legacyEntity->id,
            'entity_id' => $legacyEntity->id,
            'type' => 'character',
            '_formatted' => ['entry' => 'Legacy <mark>avatar</mark> match'],
        ],
        [
            'id' => 'character_' . $fallbackEntity->id,
            'entity_id' => $fallbackEntity->id,
            'type' => 'character',
            '_formatted' => ['entry' => 'Fallback <mark>avatar</mark> match'],
        ],
    ];

    $stubService = new class($hits) extends EntitySearchService
    {
        /**
         * @param  array<int, array<string, mixed>>  $hits
         */
        public function __construct(private readonly array $hits) {}

        protected function runMultiSearch(array $queries): array
        {
            return [
                'results' => [
                    ['hits' => $this->hits],
                ],
            ];
        }
    };

    $this->app->instance(EntitySearchService::class, $stubService);

    $response = $this->getJson(route('search.command', [
        'campaign' => $this->campaign,
        'q' => 'avatar',
        'mode' => 'fulltext',
    ]))->assertSuccessful();

    $results = collect($response->json('results'))->keyBy('id');

    $expectedGalleryImage = Avatar::for($galleryEntity->fresh(['image', 'entityType']))
        ->campaign($this->campaign)
        ->fallback()
        ->size(64)
        ->thumbnail();

    $expectedLegacyImage = Avatar::for($legacyEntity->fresh(['image', 'entityType']))
        ->campaign($this->campaign)
        ->fallback()
        ->size(64)
        ->thumbnail();

    $expectedFallbackImage = Avatar::for($fallbackEntity->fresh(['image', 'entityType']))
        ->campaign($this->campaign)
        ->fallback()
        ->size(64)
        ->thumbnail();

    expect($results->get($galleryEntity->id)['image'])->toBe($expectedGalleryImage)
        ->and($results->get($galleryEntity->id)['image'])->not->toBe($expectedFallbackImage)
        ->and($results->get($legacyEntity->id)['image'])->toBe($expectedLegacyImage)
        ->and($results->get($legacyEntity->id)['image'])->not->toBe($expectedFallbackImage)
        ->and($results->get($legacyEntity->id)['image'])->toContain('test-avatar.png')
        ->and($results->get($fallbackEntity->id)['image'])->toBe($expectedFallbackImage);
});

it('returns matching helper pages in full-text command search', function (string $query, string $expectedRouteName) {
    $stubService = new class extends EntitySearchService
    {
        protected function runMultiSearch(array $queries): array
        {
            return [
                'results' => [
                    ['hits' => []],
                ],
            ];
        }
    };

    $this->app->instance(EntitySearchService::class, $stubService);

    $response = $this->getJson(route('search.command', [
        'campaign' => $this->campaign,
        'q' => $query,
        'mode' => 'fulltext',
    ]))->assertSuccessful();

    $pages = collect($response->json('pages'));

    expect($pages->pluck('url'))->toContain(route($expectedRouteName, $this->campaign));
})->with([
    'roles' => ['roles', 'campaign_roles.index'],
    'css' => ['css', 'campaign_styles.index'],
    'theme' => ['theme', 'campaign_styles.index'],
    'sidebar' => ['sidebar', 'campaign-sidebar'],
    'join requests' => ['join requests', 'applications.index'],
    'applications' => ['applications', 'applications.index'],
    'import' => ['import', 'campaign.import'],
    'export' => ['export', 'campaign.export'],
    'defaults' => ['defaults', 'campaign-defaults'],
]);

it('returns matching helper pages in name command search', function (string $query, string $expectedRouteName) {
    $stubNameLookup = new class extends NameLookupService
    {
        public function __construct() {}

        public function find(): array
        {
            return ['entities' => []];
        }
    };

    $this->app->instance(NameLookupService::class, $stubNameLookup);

    $response = $this->getJson(route('search.command', [
        'campaign' => $this->campaign,
        'q' => $query,
        'mode' => 'name',
    ]))->assertSuccessful();

    $pages = collect($response->json('pages'));

    expect($pages->pluck('url'))->toContain(route($expectedRouteName, $this->campaign));
})->with([
    'sidebar' => ['sidebar', 'campaign-sidebar'],
    'join requests' => ['join requests', 'applications.index'],
    'applications' => ['applications', 'applications.index'],
    'import' => ['import', 'campaign.import'],
    'export' => ['export', 'campaign.export'],
    'defaults' => ['defaults', 'campaign-defaults'],
]);

it('returns empty pages for short queries in full-text command search', function () {
    $this->getJson(route('search.command', [
        'campaign' => $this->campaign,
        'q' => 'r',
        'mode' => 'fulltext',
    ]))
        ->assertSuccessful()
        ->assertJsonPath('results', [])
        ->assertJsonPath('pages', []);
});

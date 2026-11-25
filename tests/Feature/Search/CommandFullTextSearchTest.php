<?php

use App\Models\Campaign;
use App\Models\Character;
use App\Models\Image;
use App\Services\Images\Avatar;
use App\Services\Search\EntitySearchService;

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

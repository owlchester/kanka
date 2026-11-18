<?php

use App\Models\Campaign;
use App\Models\Character;
use App\Models\Entity;
use App\Services\Search\AdminPageService;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Passport\Passport;

beforeEach(function () {
    $this->asUser()->withCampaign();
    $this->campaign = Campaign::findOrFail(1);
});

afterEach(function () {
    $scopes = Entity::getAllGlobalScopes();
    unset($scopes[Entity::class]['maintenance-test-ordering']);
    Entity::setAllGlobalScopes($scopes);
});

it('shows a maintenance notice instead of querying full-text search on the standalone page', function () {
    config(['scout.search_maintenance' => true]);

    $this->get(route('search.fulltext', ['campaign' => $this->campaign, 'term' => 'needle']))
        ->assertSuccessful()
        ->assertSee(__('search/fulltext.maintenance'));
});

it('reports maintenance accurately for short full-text queries and recent payloads', function (bool $maintenance) {
    config(['scout.search_maintenance' => $maintenance]);

    $this->getJson(route('search.command', ['campaign' => $this->campaign, 'q' => 'n', 'mode' => 'fulltext']))
        ->assertSuccessful()
        ->assertJsonPath('maintenance', $maintenance)
        ->assertJsonPath('message', $maintenance ? __('search/fulltext.maintenance') : null);

    $this->getJson(route('search.recent', ['campaign' => $this->campaign]))
        ->assertSuccessful()
        ->assertJsonPath('texts.fulltext_search_available', ! $maintenance)
        ->assertJsonPath('texts.fulltext_maintenance', __('search/fulltext.maintenance'));
})->with([
    'maintenance enabled' => [true],
    'maintenance disabled' => [false],
]);

it('returns a localized API 503 during maintenance while preserving authorization', function () {
    config(['scout.search_maintenance' => true]);
    $url = '/api/1.0/campaigns/' . $this->campaign->id . '/fulltext-search?term=needle';

    $user = auth()->user();
    auth()->forgetGuards();
    $this->getJson($url)->assertUnauthorized();

    Passport::actingAs($user, ['*']);
    $this->getJson($url)
        ->assertStatus(503)
        ->assertJsonPath('message', __('search/fulltext.maintenance'));
});

it('keeps SQL name search available while full-text maintenance is enabled', function () {
    config(['scout.search_maintenance' => true]);
    Entity::addGlobalScope('maintenance-test-ordering', fn (Builder $query) => $query->reorder());
    $entity = Character::factory()->create([
        'campaign_id' => $this->campaign->id,
        'name' => 'SQL Search Target',
    ])->entity;
    $this->mock(AdminPageService::class, function ($mock) {
        $mock->shouldReceive('campaign')->andReturnSelf();
        $mock->shouldReceive('match')->andReturn([]);
    });

    $this->getJson(route('search.command', ['campaign' => $this->campaign, 'q' => 'needle', 'mode' => 'fulltext']))
        ->assertSuccessful()
        ->assertJsonPath('maintenance', true);

    $this->getJson(route('search.command', ['campaign' => $this->campaign, 'q' => 'SQL Search', 'mode' => 'name']))
        ->assertSuccessful()
        ->assertJsonMissingPath('maintenance')
        ->assertJsonFragment(['id' => $entity->id, 'name' => 'SQL Search Target']);

});

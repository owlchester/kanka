<?php

use App\Http\Requests\API\PatchEntity;
use App\Models\Campaign;
use App\Models\CampaignPermission;
use App\Models\Character;
use App\Models\Entity;
use App\Models\EntityType;
use App\Services\QuickCreator\ProcessService;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

it('excludes non-admin privacy and unknown fields from entity validation', function (string $requestClass, bool $admin) {
    $this->asUser()->withCampaign();
    if (! $admin) {
        $this->asPlayer();
    }

    $request = $requestClass::create('/', 'POST', [
        'name' => 'Validated entity',
        'is_private' => true,
        'unexpected' => 'ignored',
    ]);
    $route = new Route('POST', '/', fn () => null);
    $route->bind($request);
    $route->setParameter('campaign', Campaign::findOrFail(1));
    $request->setRouteResolver(fn () => $route);
    $request->setUserResolver(fn () => auth()->user());

    $rules = $request->rules();
    $validated = validator($request->all(), [
        'name' => $rules['name'],
        'is_private' => $rules['is_private'],
    ])->validate();

    expect($validated)->not->toHaveKey('unexpected');
    if ($admin) {
        expect($validated)->toHaveKey('is_private', true);
    } else {
        expect($validated)->not->toHaveKey('is_private');
    }
})->with(array_map(
    fn (string $name) => ['App\\Http\\Requests\\Store' . $name],
    ['Ability', 'AttributeTemplate', 'Calendar', 'Character', 'Conversation', 'Creature', 'CustomEntity', 'DiceRoll', 'Event', 'Family', 'Item', 'Journal', 'Location', 'Map', 'Note', 'Organisation', 'Quest', 'Race', 'Tag', 'Timeline', 'Whiteboard'],
) + ['entity patch' => [PatchEntity::class]])->with([true, false]);

it('ignores unvalidated model fields on API entity updates', function () {
    $this->asUser()->withCampaign()->withCharacters();

    $this->putJson('/api/1.0/campaigns/1/characters/1', [
        'name' => 'Validated character',
        'campaign_id' => 999,
        'unexpected' => ['arbitrary' => 'input'],
    ])->assertSuccessful();

    expect(Character::findOrFail(1)->campaign_id)->toBe(1);
});

it('uses the privacy rule on web entity creation', function (bool $admin) {
    $this->asUser()->withCampaign();
    if (! $admin) {
        $this->asPlayer();
        CampaignPermission::create([
            'campaign_id' => 1,
            'campaign_role_id' => 3,
            'entity_type_id' => config('entities.ids.character'),
            'action' => CampaignPermission::ACTION_ADD,
            'access' => true,
        ]);
    }

    $this->post(route('characters.store', [1]), [
        'name' => 'Web privacy test',
        'is_private' => true,
        'unexpected' => 'ignored',
    ])->assertRedirect();

    $entity = Entity::withoutGlobalScopes()->where('name', 'Web privacy test')->firstOrFail();

    expect((bool) $entity->is_private)->toBe($admin);
})->with([true, false]);

it('uses validated privacy when quick creating entities', function (bool $admin) {
    $this->asUser()->withCampaign();
    if (! $admin) {
        $this->asPlayer();
    }
    $campaign = Campaign::findOrFail(1);
    $request = Request::create('/', 'POST', [
        'name' => 'Quick privacy test',
        'is_private' => true,
    ]);
    $route = new Route('POST', '/', fn () => null);
    $route->bind($request);
    $route->setParameter('campaign', $campaign);
    $request->setRouteResolver(fn () => $route);
    $request->setUserResolver(fn () => auth()->user());

    app(ProcessService::class)
        ->campaign($campaign)
        ->entityType(EntityType::findOrFail(config('entities.ids.character')))
        ->user(auth()->user())
        ->request($request)
        ->entity();

    $entity = Entity::withoutGlobalScopes()->where('name', 'Quick privacy test')->firstOrFail();

    expect((bool) $entity->is_private)->toBe($admin);
})->with([true, false]);

it('ignores private visibility and unvalidated model fields on web entity updates', function () {
    $this->asUser()->withCampaign()->withCharacters()->asPlayer();
    CampaignPermission::create([
        'campaign_id' => 1,
        'campaign_role_id' => 3,
        'entity_type_id' => config('entities.ids.character'),
        'action' => CampaignPermission::ACTION_EDIT,
        'access' => true,
    ]);
    $character = Character::findOrFail(1);

    $this->patch(route('entities.update', [1, $character->entity]), [
        'name' => 'Public character',
        'is_private' => true,
        'campaign_id' => 999,
    ])->assertRedirect();

    expect($character->fresh()->campaign_id)->toBe(1)
        ->and($character->fresh()->entity->is_private)->toBeFalse();
});

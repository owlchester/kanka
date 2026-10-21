<?php

use App\Models\Campaign;
use App\Models\Character;
use App\Models\Entity;
use App\Models\EntityType;
use App\Services\Entity\EntitySaveService;
use App\Services\Entity\TagService;
use App\Services\PermissionService;
use App\Services\QuickCreator\ProcessService;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

it('does not allow the quick creator flag to bypass regular API validation', function (string $endpoint, string $field) {
    $this->asUser()->withCampaign();

    $this->postJson('/api/1.0/campaigns/1/' . $endpoint, [
        'name' => 'Full validation required',
        'quick-creator' => '1',
    ])->assertUnprocessable()->assertJsonStructure(['fields' => [$field]]);
})->with([
    ['calendars', 'month_name'],
    ['dice_rolls', 'parameters'],
]);

it('quick creates abbreviated entities without a client flag', function (string $type) {
    $this->asUser()->withCampaign();
    $campaign = Campaign::findOrFail(1);
    $request = Request::create('/', 'POST', ['name' => 'Quick ' . $type]);
    $route = new Route('POST', '/', fn () => null);
    $route->bind($request);
    $route->setParameter('campaign', $campaign);
    $request->setRouteResolver(fn () => $route);
    $request->setUserResolver(fn () => auth()->user());

    app(ProcessService::class)
        ->campaign($campaign)
        ->entityType(EntityType::findOrFail(config('entities.ids.' . $type)))
        ->user(auth()->user())
        ->request($request)
        ->entity();

    expect(Entity::where('name', 'Quick ' . $type)->exists())->toBeTrue();
})->with(['calendar', 'dice_roll']);

it('controls permission saving explicitly rather than through request data', function (bool $savePermissions) {
    $this->asUser()->withCampaign();
    $entity = Character::factory()->create(['campaign_id' => 1])->entity;
    $permissions = Mockery::mock(PermissionService::class)->makePartial();
    $permissions->shouldReceive('save')->times($savePermissions ? 1 : 0)->andReturnSelf();

    $service = new EntitySaveService(app(TagService::class), $permissions);
    if (! $savePermissions) {
        expect($service->skipPermissions())->toBe($service);
    }
    $service->campaign(Campaign::findOrFail(1))->entity($entity)->save([
        'quick-creator' => '1',
    ]);
})->with([true, false]);

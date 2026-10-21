<?php

use App\Models\Campaign;
use App\Models\Character;
use App\Models\Entity;
use App\Models\EntityType;
use App\Models\Tag;
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
    if ($type === 'custom') {
        $entityType = new EntityType([
            'code' => 'gadget',
            'is_special' => true,
            'is_enabled' => true,
        ]);
        $entityType->campaign_id = $campaign->id;
        $entityType->singular = 'Gadget';
        $entityType->plural = 'Gadgets';
        $entityType->icon = 'fa-solid fa-gear';
        $entityType->save();
    } else {
        $entityType = EntityType::findOrFail(config('entities.ids.' . $type));
    }
    $tag = Tag::factory()->create(['campaign_id' => $campaign->id]);
    $request = Request::create('/', 'POST', [
        'name' => 'Quick ' . $type,
        'entry' => 'Shared save flow',
        'tags' => [$tag->id],
    ]);
    $route = new Route('POST', '/', fn () => null);
    $route->bind($request);
    $route->setParameter('campaign', $campaign);
    $request->setRouteResolver(fn () => $route);
    $request->setUserResolver(fn () => auth()->user());

    $service = app(ProcessService::class)
        ->campaign($campaign)
        ->entityType($entityType)
        ->user(auth()->user())
        ->request($request);
    $service->entity();

    $entity = Entity::where('name', 'Quick ' . $type)->firstOrFail();

    expect($service->count())->toBe(1)
        ->and($service->first()->id)->toBe($entity->id)
        ->and($entity->entry)->toContain('Shared save flow')
        ->and($entity->tags->modelKeys())->toBe([$tag->id]);
})->with(['calendar', 'dice_roll', 'custom']);

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

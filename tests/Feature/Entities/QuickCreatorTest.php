<?php

use App\Models\Campaign;
use App\Models\Character;
use App\Models\Entity;
use App\Models\EntityType;
use App\Models\Event;
use App\Models\Post;
use App\Models\Tag;
use App\Services\Entity\EntitySaveService;
use App\Services\Entity\EntryDateService;
use App\Services\Entity\TagService;
use App\Services\Events\ParticipantService;
use App\Services\PermissionService;
use App\Services\QuickCreator\ProcessService;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Validation\ValidationException;

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

it('copies event archetype groups and participants when quick creating an event', function (bool $grouped) {
    $this->asUser()->withCampaign();
    $source = Event::factory()->create(['campaign_id' => 1]);
    $source->entity->update(['is_template' => true]);
    $group = $source->groups()->create(['name' => 'Guests', 'colour' => '#abcdef', 'position' => 3]);
    $character = Character::factory()->create(['campaign_id' => 1]);
    $participant = ['entity_id' => $character->entity->id, 'role' => 'Speaker', 'position' => 4];
    if ($grouped) {
        $participant['group_id'] = $group->id;
    }
    $source->participants()->create($participant);
    $secondCharacter = Character::factory()->create(['campaign_id' => 1]);
    $source->participants()->create(['entity_id' => $secondCharacter->entity->id, 'role' => 'Attendee', 'position' => 4]);
    $source->groups()->create(['name' => 'Hosts', 'colour' => '#123456', 'position' => 3]);
    $request = Request::create('/', 'POST', [
        'name' => 'Quick copied event',
        'template_id' => $source->entity->id,
    ]);
    $campaign = Campaign::findOrFail(1);
    $route = new Route('POST', '/', fn () => null);
    $route->bind($request);
    $route->setParameter('campaign', $campaign);
    $request->setRouteResolver(fn () => $route);
    $request->setUserResolver(fn () => auth()->user());

    app(ProcessService::class)
        ->campaign($campaign)
        ->entityType($source->entity->entityType)
        ->user(auth()->user())
        ->request($request)
        ->entity();

    $copy = Event::query()->whereHas('entity', fn ($query) => $query->where('name', 'Quick copied event'))->firstOrFail();
    $copiedParticipant = $copy->participants()->firstOrFail();
    $sourceParticipant = $source->participants()->where('entity_id', $copiedParticipant->entity_id)->firstOrFail();
    expect($copy->groups()->count())->toBe(2)
        ->and($copy->groups()->where('name', 'Guests')->first()->only(['name', 'colour', 'position']))->toBe(['name' => 'Guests', 'colour' => '#abcdef', 'position' => 3])
        ->and($copy->groups()->pluck('name')->all())->toBe($source->groups()->pluck('name')->all())
        ->and($copiedParticipant->role)->toBe($sourceParticipant->role)
        ->and($copy->participants()->pluck('entity_id')->all())->toBe($source->participants()->pluck('entity_id')->all())
        ->and($copiedParticipant->position)->toBe(4)
        ->and($copiedParticipant->group_id !== null)->toBe($sourceParticipant->group_id !== null)
        ->and($sourceParticipant->group_id === null ? null : $copy->groups()->find($copiedParticipant->group_id)->name)->toBe($sourceParticipant->group_id === null ? null : $group->name)
        ->and($source->groups()->count())->toBe(2)
        ->and($sourceParticipant->group_id)->toBe($grouped && $sourceParticipant->entity_id === $character->entity->id ? $group->id : null);
})->with([true, false]);

it('saves submitted quick-creator event participants once instead of copying archetype participants again', function (bool $empty) {
    $this->asUser()->withCampaign();
    $source = Event::factory()->create(['campaign_id' => 1]);
    $source->entity->update(['is_template' => true]);
    $character = Character::factory()->create(['campaign_id' => 1]);
    $group = $source->groups()->create(['name' => 'Source group']);
    $source->participants()->create(['entity_id' => $character->entity->id, 'group_id' => $group->id, 'role' => 'Source role']);
    $state = app(ParticipantService::class)->state(new Event);
    if (! $empty) {
        $state['participants'] = [['entity_id' => $character->entity->id, 'group' => null, 'role' => 'Submitted role']];
    }

    $this->post(route('entity-creator.store', ['test-campaign', $source->entity->entityType]), [
        'name' => 'Quick submitted event',
        'template_id' => $source->entity->id,
        'event_participants' => json_encode($state),
    ])->assertSuccessful();
    $copy = Event::query()->whereHas('entity', fn ($query) => $query->where('name', 'Quick submitted event'))->firstOrFail();

    expect($copy->participants()->count())->toBe($empty ? 0 : 1)
        ->and($empty ? null : $copy->participants()->first()->role)->toBe($empty ? null : 'Submitted role')
        ->and($source->participants()->count())->toBe(1)
        ->and($source->participants()->first()->role)->toBe('Source role');
})->with([false, true]);

it('controls permission saving explicitly rather than through request data', function (bool $savePermissions) {
    $this->asUser()->withCampaign();
    $entity = Character::factory()->create(['campaign_id' => 1])->entity;
    $permissions = Mockery::mock(PermissionService::class)->makePartial();
    $permissions->shouldReceive('save')->times($savePermissions ? 1 : 0)->andReturnSelf();

    $service = new EntitySaveService(app(TagService::class), $permissions, app(EntryDateService::class));
    if (! $savePermissions) {
        expect($service->skipPermissions())->toBe($service);
    }
    $service->campaign(Campaign::findOrFail(1))->entity($entity)->save([
        'quick-creator' => '1',
    ]);
})->with([true, false]);

it('only persists validated fields when quick creating posts', function (int $position) {
    $this->asUser()->withCampaign();
    $entity = Character::factory()->create(['campaign_id' => 1])->entity;
    $existing = Post::factory()->create(['entity_id' => $entity->id, 'position' => 1]);
    $request = Request::create('/', 'POST', [
        'name' => 'Quick post',
        'entry' => 'Validated description',
        'entity_id' => $entity->id,
        'position' => $position,
        'is_template' => true,
        'settings' => ['unexpected' => 'ignored'],
    ]);

    $service = app(ProcessService::class)->campaign(Campaign::findOrFail(1))->request($request);
    $service->post();

    $post = $service->first()->fresh();

    expect($post->entity_id)->toBe($entity->id)
        ->and($post->name)->toBe('Quick post')
        ->and($post->entry)->toContain('Validated description')
        ->and($post->is_template)->toBeFalse()
        ->and((array) $post->settings)->not->toHaveKey('unexpected')
        ->and($existing->fresh()->position)->toBe($position === 1 ? 2 : 1);
})->with([0, 1]);

it('quick creates multiple posts from validated data', function () {
    $this->asUser()->withCampaign();
    $entity = Character::factory()->create(['campaign_id' => 1])->entity;
    $request = Request::create('/', 'POST', [
        'name' => "First post\nSecond post",
        'entity_id' => $entity->id,
        'position' => 0,
        'is_template' => true,
    ]);

    $service = app(ProcessService::class)->campaign(Campaign::findOrFail(1))->request($request);
    $service->post();

    expect($service->count())->toBe(2)
        ->and($entity->posts()->orderBy('id')->pluck('name')->all())->toBe(['First post', 'Second post'])
        ->and($entity->posts()->where('is_template', true)->exists())->toBeFalse();
});

it('does not create quick posts with invalid fields', function () {
    $this->asUser()->withCampaign();
    $entity = Character::factory()->create(['campaign_id' => 1])->entity;
    $request = Request::create('/', 'POST', [
        'name' => 'Invalid post',
        'entity_id' => $entity->id,
        'position' => 'invalid',
    ]);

    $service = app(ProcessService::class)->campaign(Campaign::findOrFail(1))->request($request);

    expect(fn () => $service->post())->toThrow(ValidationException::class)
        ->and($entity->posts()->exists())->toBeFalse();
});

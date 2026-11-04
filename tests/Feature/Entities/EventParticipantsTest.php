<?php

use App\Facades\EntityPermission;
use App\Facades\Permissions;
use App\Models\Campaign;
use App\Models\Character;
use App\Models\Event;
use App\Models\EventGroup;
use App\Models\EventParticipant;
use App\Services\Events\ParticipantService;
use App\Services\Permissions\PermissionService;

function participantPayload(Event $event): array
{
    return app(ParticipantService::class)->state($event);
}

it('adds event participants to custom groups and preserves them when a group is deleted', function () {
    $this->asUser()->withCampaign();
    $event = Event::factory()->create(['campaign_id' => 1]);
    $character = Character::factory()->create(['campaign_id' => 1]);

    $this->post(route('events.groups.store', [1, $event]), ['name' => 'Defenders'])
        ->assertRedirect(route('events.participants.index', ['test-campaign', $event]));
    $group = EventGroup::query()->firstOrFail();

    $this->post(route('events.participants.store', [1, $event]), [
        'entity_id' => $character->entity->id,
        'group_id' => $group->id,
        'role' => 'Commander',
    ])->assertRedirect(route('events.participants.index', ['test-campaign', $event]));

    $participant = EventParticipant::query()->firstOrFail();
    expect($participant->role)->toBe('Commander')
        ->and($participant->group_id)->toBe($group->id);

    $this->get(route('events.participants.index', ['test-campaign', $event]))->assertSuccessful();

    $this->delete(route('events.groups.destroy', [1, $event, $group]))
        ->assertRedirect(route('events.participants.index', ['test-campaign', $event]));

    expect($participant->fresh()->group_id)->toBeNull();
});

it('does not allow participants from another campaign or duplicate participants', function () {
    $this->asUser()->withCampaign();
    Campaign::factory()->create(['slug' => 'other-campaign']);
    $event = Event::factory()->create(['campaign_id' => 1]);
    $character = Character::factory()->create(['campaign_id' => 1]);
    $otherCampaignCharacter = Character::factory()->create(['campaign_id' => 2]);

    $route = route('events.participants.store', [1, $event]);
    $this->post($route, ['entity_id' => $otherCampaignCharacter->entity->id])->assertSessionHasErrors('entity_id');
    $this->post($route, ['entity_id' => $character->entity->id])->assertRedirect();
    $this->post($route, ['entity_id' => $character->entity->id])->assertSessionHasErrors('entity_id');
});

it('does not write during the legacy maintenance preflight', function () {
    $this->asUser()->withCampaign();
    $event = Event::factory()->create(['campaign_id' => 1]);
    $character = Character::factory()->create(['campaign_id' => 1]);
    $headers = ['X-Requested-With' => 'XMLHttpRequest'];

    $this->post(route('events.groups.store', [1, $event]), ['name' => 'Defenders'], $headers)->assertSuccessful();
    $this->post(route('events.participants.store', [1, $event]), ['entity_id' => $character->entity->id], $headers)->assertSuccessful();
    expect($event->groups()->count())->toBe(0)->and($event->participants()->count())->toBe(0);
});

it('saves batches, inline edits, group moves and ordering without redirects', function () {
    $this->asUser()->withCampaign();
    $event = Event::factory()->create(['campaign_id' => 1]);
    $characters = Character::factory()->count(2)->create(['campaign_id' => 1]);
    $payload = participantPayload($event);
    $payload['groups'] = [['key' => 'new-defenders', 'name' => 'Defenders', 'colour' => '#112233']];
    $payload['participants'] = $characters->map(fn ($character) => [
        'entity_id' => $character->entity->id, 'group' => 'new-defenders', 'role' => null,
    ])->all();

    $url = route('events.participants.update', [1, $event]);
    $response = $this->putJson($url, $payload)->assertSuccessful()->assertJsonCount(2, 'participants');
    expect($event->groups()->count())->toBe(1);
    $payload = $response->json();
    $payload['participants'] = array_reverse($payload['participants']);
    $payload['participants'][0]['role'] = 'Commander';
    $payload['participants'][0]['group'] = null;
    $response = $this->putJson($url, $payload)->assertSuccessful();
    expect($response->json('participants.0.role'))->toBe('Commander')
        ->and($response->json('participants.0.group'))->toBeNull();
    $payload = $response->json();
    $payload['groups'] = [];
    foreach ($payload['participants'] as &$participant) {
        $participant['group'] = null;
    }
    unset($participant);
    $this->putJson($url, $payload)->assertSuccessful();
    expect($event->participants()->whereNotNull('group_id')->count())->toBe(0)
        ->and($event->participants()->count())->toBe(2);
});

it('rejects stale saves instead of overwriting other changes or duplicating groups', function () {
    $this->asUser()->withCampaign();
    $event = Event::factory()->create(['campaign_id' => 1]);
    $payload = participantPayload($event);
    $payload['groups'] = [['key' => 'new-one', 'name' => 'Defenders', 'colour' => null]];
    $url = route('events.participants.update', [1, $event]);
    $this->putJson($url, $payload)->assertSuccessful();
    $this->putJson($url, $payload)->assertConflict();
    expect($event->groups()->count())->toBe(1);
});

it('rejects invalid groups, colours and duplicate participants atomically', function () {
    $this->asUser()->withCampaign();
    $event = Event::factory()->create(['campaign_id' => 1]);
    $otherEvent = Event::factory()->create(['campaign_id' => 1]);
    $group = $otherEvent->groups()->create(['name' => 'Other event']);
    $character = Character::factory()->create(['campaign_id' => 1]);
    $url = route('events.participants.update', [1, $event]);
    $payload = participantPayload($event);
    $payload['groups'] = [['key' => (string) $group->id, 'name' => 'Foreign', 'colour' => null]];
    $this->putJson($url, $payload)->assertUnprocessable();
    $payload['groups'] = [['key' => 'new-one', 'name' => 'Group', 'colour' => 'red']];
    $this->putJson($url, $payload)->assertUnprocessable();
    $payload['groups'][0]['colour'] = null;
    $entry = ['entity_id' => $character->entity->id, 'group' => null, 'role' => null];
    $payload['participants'] = [$entry, $entry];
    $this->putJson($url, $payload)->assertUnprocessable();
    expect($event->groups()->count())->toBe(0)->and($event->participants()->count())->toBe(0);
});

it('preserves inaccessible participants omitted from the manager', function () {
    $this->asUser()->withCampaign();
    $event = Event::factory()->create(['campaign_id' => 1]);
    $character = Character::factory()->create(['campaign_id' => 1, 'is_private' => true]);
    $event->participants()->create(['entity_id' => $character->entity->id]);
    $this->asPlayer();
    $state = participantPayload($event);
    expect($state['participants'])->toBeEmpty();
    app(ParticipantService::class)->save($event, $state);
    expect($event->participants()->count())->toBe(1);
});

it('prevents players without event edit permission from saving participants', function () {
    $this->asUser()->withCampaign();
    $event = Event::factory()->create(['campaign_id' => 1]);
    $payload = participantPayload($event);
    $this->asPlayer();
    EntityPermission::swap((new App\Services\Permissions\EntityPermission)->campaign(Campaign::findOrFail(1)));
    expect(auth()->user()->can('update', $event->entity))->toBeFalse();
    $this->putJson(route('events.participants.update', [1, $event]), $payload)->assertForbidden();
});

it('saves staged participants with a new event after a validation-only preflight', function () {
    $this->asUser()->withCampaign();
    $character = Character::factory()->create(['campaign_id' => 1]);
    $payload = participantPayload(new Event);
    $payload['groups'] = [['key' => 'new-side', 'name' => 'Guests', 'colour' => '#abcdef']];
    $payload['participants'] = [['entity_id' => $character->entity->id, 'group' => 'new-side', 'role' => 'Guest']];
    $data = ['name' => 'Celebration', 'event_participants' => json_encode($payload)];
    $url = route('events.store', [1]);
    $this->post($url, $data, ['X-Requested-With' => 'XMLHttpRequest'])->assertSuccessful();
    expect(EventParticipant::count())->toBe(0);
    $this->post($url, $data)->assertRedirect();
    expect(EventParticipant::count())->toBe(1)->and(EventGroup::first()->name)->toBe('Guests');
});

it('prefills copied event participants and persists them without changing the source', function () {
    $this->asUser()->withCampaign();
    $source = Event::factory()->create(['campaign_id' => 1]);
    $group = $source->groups()->create(['name' => 'Guests', 'colour' => '#abcdef']);
    $character = Character::factory()->create(['campaign_id' => 1]);
    $source->participants()->create(['entity_id' => $character->entity->id, 'group_id' => $group->id, 'role' => 'Speaker']);

    $type = $source->entity->entityType;
    $response = $this->followingRedirects()->get(route('entities.create', ['test-campaign', $type, 'copy' => $source->entity->id]))->assertSuccessful();
    preg_match('/<script type="application\/json" class="js-participant-config">(.*?)<\/script>/s', $response->getContent(), $matches);
    $initial = json_decode($matches[1], true, flags: JSON_THROW_ON_ERROR)['initial'];
    $emptyEvent = new Event;
    $emptyEvent->campaign_id = 1;
    expect($initial['groups'][0]['key'])->toBe('new-copy-0')
        ->and($initial['participants'][0]['group'])->toBe('new-copy-0')
        ->and($initial['revision'])->toBe(participantPayload($emptyEvent)['revision']);

    $this->post(route('events.store', [1]), [
        'name' => 'Copied event',
        'event_participants' => json_encode($initial),
    ])->assertRedirect();
    $new = Event::query()->where('campaign_id', 1)->latest('id')->firstOrFail();

    expect($new->groups()->first()->name)->toBe('Guests')
        ->and($new->participants()->first()->role)->toBe('Speaker')
        ->and($new->participants()->first()->group_id)->toBe($new->groups()->first()->id)
        ->and($source->groups()->count())->toBe(1)
        ->and($source->participants()->first()->group_id)->toBe($group->id);
});

it('prefers valid old staged participant input when creating an event', function () {
    $this->asUser()->withCampaign();
    $source = Event::factory()->create(['campaign_id' => 1]);
    $group = $source->groups()->create(['name' => 'Source group']);
    $character = Character::factory()->create(['campaign_id' => 1]);
    $source->participants()->create(['entity_id' => $character->entity->id, 'group_id' => $group->id, 'role' => 'Source role']);
    $type = $source->entity->entityType;
    $url = route('entities.create', ['test-campaign', $type, 'copy' => $source->entity->id]);
    $edited = participantPayload(new Event);
    $edited['groups'] = [];
    $edited['participants'] = [];

    $response = $this->followingRedirects()->withSession(['_old_input' => ['event_participants' => json_encode($edited)]])->get($url)->assertSuccessful();
    preg_match('/<script type="application\/json" class="js-participant-config">(.*?)<\/script>/s', $response->getContent(), $matches);
    $initial = json_decode($matches[1], true, flags: JSON_THROW_ON_ERROR)['initial'];
    expect($initial)->toBe($edited)
        ->and($initial['groups'])->toBeEmpty()
        ->and($initial['participants'])->toBeEmpty();
});

it('saves staged participant edits through the unified event editor', function () {
    $this->asUser()->withCampaign();
    $event = Event::factory()->create(['campaign_id' => 1]);
    $character = Character::factory()->create(['campaign_id' => 1]);
    $payload = participantPayload($event);
    $payload['participants'] = [['entity_id' => $character->entity->id, 'group' => null, 'role' => 'Witness']];
    $this->patch(route('entities.update', [1, $event->entity]), [
        'name' => $event->entity->name, 'event_participants' => json_encode($payload),
    ])->assertRedirect();
    expect($event->participants()->first()->role)->toBe('Witness');
});

it('validates staged participant references before updating the event', function () {
    $this->asUser()->withCampaign();
    $event = Event::factory()->create(['campaign_id' => 1]);
    $otherEvent = Event::factory()->create(['campaign_id' => 1]);
    $group = $otherEvent->groups()->create(['name' => 'Foreign group']);
    $payload = participantPayload($event);
    $payload['groups'] = [['key' => (string) $group->id, 'name' => 'Foreign', 'colour' => null]];
    $this->patch(route('entities.update', [1, $event->entity]), [
        'name' => 'Should not be saved', 'event_participants' => json_encode($payload),
    ])->assertSessionHasErrors('event_participants');
    expect($event->entity->fresh()->name)->not->toBe('Should not be saved');
});

it('leaves participation unchanged when omitted and clears it when explicitly emptied in the editor', function () {
    $this->asUser()->withCampaign();
    $event = Event::factory()->create(['campaign_id' => 1]);
    $character = Character::factory()->create(['campaign_id' => 1]);
    $event->participants()->create(['entity_id' => $character->entity->id]);
    $url = route('entities.update', [1, $event->entity]);
    $this->patch($url, ['name' => $event->entity->name])->assertRedirect();
    expect($event->participants()->count())->toBe(1);
    $payload = participantPayload($event);
    $payload['participants'] = [];
    $this->patch($url, ['name' => $event->entity->name, 'event_participants' => json_encode($payload)])->assertRedirect();
    expect($event->participants()->count())->toBe(0);
});

it('shows and sorts event participant counts without counting deleted entities', function () {
    $this->asUser()->withCampaign();
    $first = Event::factory()->create(['campaign_id' => 1, 'name' => 'First']);
    $second = Event::factory()->create(['campaign_id' => 1, 'name' => 'Second']);
    $third = Event::factory()->create(['campaign_id' => 1, 'name' => 'Third']);
    $characters = Character::factory()->count(3)->create(['campaign_id' => 1]);
    $second->participants()->create(['entity_id' => $characters[0]->entity->id]);
    $third->participants()->create(['entity_id' => $characters[1]->entity->id]);
    $third->participants()->create(['entity_id' => $characters[2]->entity->id]);
    $first->participants()->create(['entity_id' => $characters[2]->entity->id]);
    $characters[2]->entity->delete();
    $type = $first->entity->entityType;

    $response = $this->getJson(route('entities.index-api', [1, $type, 'order' => 'participants_count']))
        ->assertSuccessful()->assertJsonPath('error', false);
    $rows = collect($response->json('entities.data'));
    expect($rows->pluck('participants_count')->all())->toBe([0, 1, 1])
        ->and($rows->pluck('id')->all())->toBe([$first->entity->id, $second->entity->id, $third->entity->id]);

    $response = $this->getJson(route('entities.index-api', [1, $type, 'order' => 'participants_count', 'desc' => 1]))
        ->assertSuccessful()->assertJsonPath('error', false);
    expect(collect($response->json('entities.data'))->pluck('participants_count')->all())->toBe([1, 1, 0]);
    expect(collect($response->json('columns'))->firstWhere('key', 'participants_count')['sortable'])->toBeTrue();
});

it('uses visible participant counts for both listing and ordering', function () {
    $this->asUser()->withCampaign();
    $first = Event::factory()->create(['campaign_id' => 1, 'name' => 'First']);
    $second = Event::factory()->create(['campaign_id' => 1, 'name' => 'Second']);
    $visible = Character::factory()->create(['campaign_id' => 1]);
    $hidden = Character::factory()->create(['campaign_id' => 1, 'is_private' => true]);
    $first->participants()->create(['entity_id' => $hidden->entity->id]);
    $second->participants()->create(['entity_id' => $visible->entity->id]);
    $type = $first->entity->entityType;
    $this->asPlayer();
    Permissions::swap(new PermissionService);

    $response = $this->getJson(route('entities.index-api', [1, $type, 'order' => 'participants_count']))
        ->assertSuccessful()->assertJsonPath('error', false);
    $rows = collect($response->json('entities.data'));
    expect($rows->pluck('id')->all())->toBe([$first->entity->id, $second->entity->id])
        ->and($rows->pluck('participants_count')->all())->toBe([0, 1]);
});

it('shows grouped and ungrouped participants in saved order in the event profile sidebar', function () {
    $this->asUser()->withCampaign();
    $event = Event::factory()->create(['campaign_id' => 1, 'name' => 'The Great Battle']);
    $group = $event->groups()->create(['name' => 'Defenders', 'position' => 0]);
    $first = Character::factory()->create(['campaign_id' => 1, 'name' => 'First Guard']);
    $second = Character::factory()->create(['campaign_id' => 1, 'name' => 'Second Guard']);
    $solo = Character::factory()->create(['campaign_id' => 1, 'name' => 'Observer']);
    $event->participants()->create(['entity_id' => $first->entity->id, 'group_id' => $group->id, 'position' => 0, 'role' => 'Captain']);
    $event->participants()->create(['entity_id' => $second->entity->id, 'group_id' => $group->id, 'position' => 1]);
    $event->participants()->create(['entity_id' => $solo->entity->id, 'role' => 'Chronicler']);

    $response = $this->get(route('entities.show', [1, $event->entity]))->assertSuccessful();
    $html = $response->getContent();
    expect($html)
        ->toContain('sidebar-event-participants')
        ->toContain('Defenders')
        ->toContain('Captain')
        ->toContain('Other participants')
        ->toContain('Chronicler')
        ->and(strpos($html, 'First Guard'))->toBeLessThan(strpos($html, 'Second Guard'));
});

it('does not expose inaccessible participant entities in the event profile sidebar', function () {
    $this->asUser()->withCampaign();
    $event = Event::factory()->create(['campaign_id' => 1, 'name' => 'Private Battle']);
    $group = $event->groups()->create(['name' => 'Side']);
    $visible = Character::factory()->create(['campaign_id' => 1, 'name' => 'Visible Scout']);
    $hidden = Character::factory()->create(['campaign_id' => 1, 'name' => 'Hidden Scout', 'is_private' => true]);
    $event->participants()->create(['entity_id' => $visible->entity->id, 'group_id' => $group->id]);
    $event->participants()->create(['entity_id' => $hidden->entity->id, 'group_id' => $group->id]);

    $this->asPlayer();
    $response = $this->get(route('entities.show', [1, $event->entity]))->assertSuccessful();
    expect($response->getContent())->toContain('Visible Scout')->not->toContain('Hidden Scout');
});

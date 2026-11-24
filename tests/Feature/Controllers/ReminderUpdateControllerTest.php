<?php

use App\Enums\EntityEventTypes;
use App\Enums\Visibility;
use App\Facades\Permissions;
use App\Models\Calendar;
use App\Models\Campaign;
use App\Models\CampaignPermission;
use App\Models\Character;
use App\Models\Entity;
use App\Models\Post;
use App\Models\Reminder;
use App\Services\Permissions\EntityPermission as EntityPermissionService;
use App\Services\Permissions\RolePermission as RolePermissionService;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

function switchToPlayerWithFreshPermissions(TestCase $test, Campaign $campaign): void
{
    $test->asPlayer();
    Permissions::reset();
    app()->forgetInstance(RolePermissionService::class);
    app(EntityPermissionService::class)->resetPermissions();
}

test('player cannot edit, update, or delete a post reminder whose calendar is private', function () {
    $this->asUser()->withCampaign();

    $campaign = Campaign::findOrFail(1);
    $character = Character::factory()->create(['campaign_id' => 1]);
    $post = Post::factory()->create([
        'entity_id' => $character->entity->id,
        'visibility_id' => Visibility::All->value,
    ]);
    $calendar = Calendar::factory()->create([
        'campaign_id' => 1,
        'is_private' => true,
    ]);
    $reminder = Reminder::factory()->create([
        'calendar_id' => $calendar->id,
        'remindable_id' => $post->id,
        'remindable_type' => Post::class,
        'type_id' => EntityEventTypes::calendarDate->value,
        'day' => 2,
        'month' => 2,
        'year' => 2,
        'length' => 1,
    ]);

    CampaignPermission::create([
        'campaign_id' => 1,
        'campaign_role_id' => 3,
        'entity_type_id' => config('entities.ids.character'),
        'action' => CampaignPermission::ACTION_EDIT,
        'access' => true,
    ]);
    switchToPlayerWithFreshPermissions($this, $campaign);

    $this->get(route('reminders.edit', [$campaign, $reminder]))->assertForbidden();
    $this->patch(route('reminders.update', [$campaign, $reminder]), [
        'day' => 5,
        'month' => 2,
        'year' => 2,
        'length' => 1,
    ])->assertForbidden();
    $this->delete(route('reminders.destroy', [$campaign, $reminder]))->assertForbidden();

    $fresh = $reminder->fresh();
    expect($fresh)->not->toBeNull()
        ->and($fresh->day)->toBe(2);
});

test('user cannot edit, update, or delete a reminder whose calendar is soft-deleted', function () {
    $this->asUser()->withCampaign();

    $campaign = Campaign::findOrFail(1);
    $character = Character::factory()->create(['campaign_id' => 1]);
    $calendar = Calendar::factory()->create(['campaign_id' => 1]);
    $reminder = Reminder::factory()->create([
        'calendar_id' => $calendar->id,
        'remindable_id' => $character->entity->id,
        'remindable_type' => Entity::class,
        'day' => 2,
        'month' => 2,
        'year' => 2,
        'length' => 1,
    ]);

    $calendar->entity->delete();

    $this->get(route('reminders.edit', [$campaign, $reminder]))->assertForbidden();
    $this->patch(route('reminders.update', [$campaign, $reminder]), [
        'day' => 5,
        'month' => 2,
        'year' => 2,
        'length' => 1,
    ])->assertForbidden();
    $this->delete(route('reminders.destroy', [$campaign, $reminder]))->assertForbidden();

    $fresh = $reminder->fresh();
    expect($fresh)->not->toBeNull()
        ->and($fresh->day)->toBe(2);
});

test('user cannot edit, update, or delete a reminder referencing a calendar or entity from another campaign', function () {
    $this->asUser()->withCampaign()->withCampaigns();

    $campaign = Campaign::findOrFail(1);
    $character = Character::factory()->create(['campaign_id' => 1]);
    $otherCharacter = Character::factory()->create(['campaign_id' => 2]);
    $otherCalendar = Calendar::factory()->create(['campaign_id' => 2]);

    $crossCalendarReminder = Reminder::factory()->create([
        'calendar_id' => $otherCalendar->id,
        'remindable_id' => $character->entity->id,
        'remindable_type' => Entity::class,
        'day' => 2,
        'month' => 2,
        'year' => 2,
        'length' => 1,
    ]);
    $otherCampaignReminder = Reminder::factory()->create([
        'calendar_id' => $otherCalendar->id,
        'remindable_id' => $otherCharacter->entity->id,
        'remindable_type' => Entity::class,
        'day' => 3,
        'month' => 2,
        'year' => 2,
        'length' => 1,
    ]);

    foreach ([$crossCalendarReminder, $otherCampaignReminder] as $reminder) {
        $originalDay = $reminder->day;

        $this->get(route('reminders.edit', [$campaign, $reminder]))->assertForbidden();
        $this->patch(route('reminders.update', [$campaign, $reminder]), [
            'day' => 9,
            'month' => 2,
            'year' => 2,
            'length' => 1,
        ])->assertForbidden();
        $this->delete(route('reminders.destroy', [$campaign, $reminder]))->assertForbidden();

        $fresh = $reminder->fresh();
        expect($fresh)->not->toBeNull()
            ->and($fresh->day)->toBe($originalDay);
    }
});

test('player with only view access to a calendar cannot edit, update, or delete its reminder', function () {
    $this->asUser()->withCampaign();

    $campaign = Campaign::findOrFail(1);
    $character = Character::factory()->create(['campaign_id' => 1]);
    $calendar = Calendar::factory()->create(['campaign_id' => 1]);
    $reminder = Reminder::factory()->create([
        'calendar_id' => $calendar->id,
        'remindable_id' => $character->entity->id,
        'remindable_type' => Entity::class,
        'day' => 2,
        'month' => 2,
        'year' => 2,
        'length' => 1,
    ]);

    CampaignPermission::create([
        'campaign_id' => 1,
        'campaign_role_id' => 3,
        'entity_type_id' => config('entities.ids.character'),
        'action' => CampaignPermission::ACTION_EDIT,
        'access' => true,
    ]);
    switchToPlayerWithFreshPermissions($this, $campaign);

    $this->get(route('reminders.edit', [$campaign, $reminder]))->assertForbidden();
    $this->patch(route('reminders.update', [$campaign, $reminder]), [
        'day' => 5,
        'month' => 2,
        'year' => 2,
        'length' => 1,
    ])->assertForbidden();
    $this->delete(route('reminders.destroy', [$campaign, $reminder]))->assertForbidden();

    $fresh = $reminder->fresh();
    expect($fresh)->not->toBeNull()
        ->and($fresh->day)->toBe(2);
});

test('campaign admin can edit, update, and delete a reminder', function () {
    $this->asUser()->withCampaign();

    $campaign = Campaign::findOrFail(1);
    $character = Character::factory()->create(['campaign_id' => 1]);
    $calendar = Calendar::factory()->create(['campaign_id' => 1]);
    $reminder = Reminder::factory()->create([
        'calendar_id' => $calendar->id,
        'remindable_id' => $character->entity->id,
        'remindable_type' => Entity::class,
        'day' => 2,
        'month' => 2,
        'year' => 2,
        'length' => 1,
    ]);

    if (! defined('LARAVEL_START')) {
        define('LARAVEL_START', microtime(true));
    }

    $this->get(route('reminders.edit', [$campaign, $reminder]))->assertSuccessful();

    $this->patch(route('reminders.update', [$campaign, $reminder]), [
        'day' => 6,
        'month' => 3,
        'year' => 4,
        'length' => 2,
    ])->assertRedirect();

    $fresh = $reminder->fresh();
    expect($fresh->day)->toBe(6)
        ->and($fresh->month)->toBe(3)
        ->and($fresh->year)->toBe(4)
        ->and($fresh->length)->toBe(2);

    $this->delete(route('reminders.destroy', [$campaign, $reminder]))->assertRedirect();

    expect(Reminder::find($reminder->id))->toBeNull();
});

test('player with edit access to both the entity and calendar can edit, update, and delete a reminder', function () {
    $this->asUser()->withCampaign();

    $campaign = Campaign::findOrFail(1);
    $character = Character::factory()->create(['campaign_id' => 1]);
    $calendar = Calendar::factory()->create(['campaign_id' => 1]);
    $reminder = Reminder::factory()->create([
        'calendar_id' => $calendar->id,
        'remindable_id' => $character->entity->id,
        'remindable_type' => Entity::class,
        'day' => 2,
        'month' => 2,
        'year' => 2,
        'length' => 1,
    ]);

    CampaignPermission::create([
        'campaign_id' => 1,
        'campaign_role_id' => 3,
        'entity_type_id' => config('entities.ids.character'),
        'action' => CampaignPermission::ACTION_EDIT,
        'access' => true,
    ]);
    CampaignPermission::create([
        'campaign_id' => 1,
        'campaign_role_id' => 3,
        'entity_type_id' => config('entities.ids.calendar'),
        'action' => CampaignPermission::ACTION_EDIT,
        'access' => true,
    ]);
    switchToPlayerWithFreshPermissions($this, $campaign);

    if (! defined('LARAVEL_START')) {
        define('LARAVEL_START', microtime(true));
    }

    $this->get(route('reminders.edit', [$campaign, $reminder]))->assertSuccessful();

    $this->patch(route('reminders.update', [$campaign, $reminder]), [
        'day' => 7,
        'month' => 4,
        'year' => 5,
        'length' => 3,
    ])->assertRedirect();

    $fresh = $reminder->fresh();
    expect($fresh->day)->toBe(7)
        ->and($fresh->month)->toBe(4)
        ->and($fresh->year)->toBe(5)
        ->and($fresh->length)->toBe(3);

    $this->delete(route('reminders.destroy', [$campaign, $reminder]))->assertRedirect();

    expect(Reminder::find($reminder->id))->toBeNull();
});

test('reminder policy denies unauthenticated guests', function () {
    $this->asUser()->withCampaign();

    $character = Character::factory()->create(['campaign_id' => 1]);
    $calendar = Calendar::factory()->create(['campaign_id' => 1]);
    $reminder = Reminder::factory()->create([
        'calendar_id' => $calendar->id,
        'remindable_id' => $character->entity->id,
        'remindable_type' => Entity::class,
    ]);

    expect(Gate::forUser(null)->allows('update', $reminder))->toBeFalse()
        ->and(Gate::forUser(null)->allows('delete', $reminder))->toBeFalse();
});

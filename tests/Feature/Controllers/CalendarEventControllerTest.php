<?php

use App\Models\Calendar;
use App\Models\Campaign;
use App\Models\Character;
use App\Models\Post;
use App\Models\Reminder;
use App\Renderers\DatagridRenderer2;
use App\Services\Campaign\LocalisationService;
use Illuminate\Support\Facades\Facade;

test('calendar events exclude post reminders without an accessible entity', function () {
    $this->asUser()->withCampaign()->withCharacters()->withCalendars();

    $campaign = Campaign::findOrFail(1);
    $calendar = Calendar::findOrFail(1);
    $validEntity = Character::findOrFail(1)->entity;
    $deletedEntity = Character::findOrFail(2)->entity;

    $validPost = Post::factory()->create([
        'entity_id' => $validEntity->id,
        'name' => 'Visible calendar post',
    ]);
    $orphanedPost = Post::factory()->create([
        'entity_id' => $deletedEntity->id,
        'name' => 'Orphaned calendar post',
    ]);

    Reminder::factory()->create([
        'calendar_id' => $calendar->id,
        'remindable_id' => $validPost->id,
        'remindable_type' => Post::class,
    ]);
    Reminder::factory()->create([
        'calendar_id' => $calendar->id,
        'remindable_id' => $orphanedPost->id,
        'remindable_type' => Post::class,
    ]);

    $deletedEntity->delete();

    app()->forgetInstance(LocalisationService::class);
    app()->forgetInstance(DatagridRenderer2::class);
    Facade::clearResolvedInstance('campaignlocalization');
    Facade::clearResolvedInstance('datagrid');

    if (! defined('LARAVEL_START')) {
        define('LARAVEL_START', microtime(true));
    }

    $this->get(route('calendars.events', [$campaign, $calendar]))
        ->assertSuccessful()
        ->assertSee($validPost->name, false)
        ->assertDontSee($orphanedPost->name, false);
});

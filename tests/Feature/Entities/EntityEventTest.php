<?php

use App\Enums\EntityEventTypes;
use App\Models\Calendar;
use App\Models\Character;
use App\Models\Entity;
use App\Models\Event;
use App\Models\Journal;
use App\Models\Quest;
use App\Models\Reminder;

it('POSTS an invalid reminders form')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->postJson('/api/1.0/campaigns/1/entities/1/reminders', [])
    ->assertStatus(422);

it('POSTS a new entity event')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withCalendars()
    ->postJson('/api/1.0/campaigns/1/entities/1/reminders', [
        'calendar_id' => 1,
        'day' => 2,
        'month' => 2,
        'year' => 2,
        'length' => 2,
        'visibility_id' => 1,
    ])
    ->assertStatus(201)
    ->assertJsonStructure([
        'data' => [
            'id',
            'calendar_id',
        ],
    ]);

it('sanitizes reminder comments created through the API')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withCalendars()
    ->postJson('/api/1.0/campaigns/1/entities/1/reminders', [
        'calendar_id' => 1,
        'day' => 2,
        'month' => 2,
        'year' => 2,
        'comment' => '<script>alert(1)</script><strong>Safe</strong>',
    ])
    ->assertStatus(201)
    ->assertJsonPath('data.comment', '<strong>Safe</strong>');

it('GETS all reminders')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withCalendars()
    ->withReminders()
    ->get('/api/1.0/campaigns/1/entities/1/reminders')
    ->assertStatus(200)
    ->assertJsonFragment([
        'id' => 1,
    ]);

it('GETS a specific entity event')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withCalendars()
    ->withReminders()
    ->get('/api/1.0/campaigns/1/entities/1/reminders/1')
    ->assertStatus(200)
    ->assertJsonStructure([
        'data' => [
            'id',
            'calendar_id',
        ],
    ]);

it('UPDATES a valid entity event')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withCalendars()
    ->withReminders()
    ->putJson('/api/1.0/campaigns/1/entities/1/reminders/1', ['length' => 2])
    ->assertStatus(200)
    ->assertJsonFragment(['length' => 2]);

it('DELETES an entity event')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withCalendars()
    ->withReminders()
    ->delete('/api/1.0/campaigns/1/entities/1/reminders/1')
    ->assertStatus(204);

it('DELETES an invalid entity event')
    ->asUser()
    ->withCampaign()
    ->withCharacters()
    ->withCalendars()
    ->withReminders()
    ->delete('/api/1.0/campaigns/1/entities/1/reminders/100')
    ->assertStatus(404);

it('sets the first reminder as the calendar date for journals, quests, and events', function () {
    $this->asUser()->withCampaign()->withCalendars();

    $calendar = Calendar::firstOrFail();
    $models = [
        Journal::factory()->create(['campaign_id' => 1]),
        Quest::factory()->create(['campaign_id' => 1]),
        Event::factory()->create(['campaign_id' => 1]),
    ];

    foreach ($models as $model) {
        $reminder = Reminder::factory()->create([
            'remindable_id' => $model->entity->id,
            'remindable_type' => Entity::class,
            'calendar_id' => $calendar->id,
        ]);

        expect($reminder->fresh()->type_id)->toBe(EntityEventTypes::calendarDate);
    }
});

it('does not replace an existing calendar date or promote other entity reminders', function () {
    $this->asUser()->withCampaign()->withCalendars();

    $calendar = Calendar::firstOrFail();
    $journal = Journal::factory()->create(['campaign_id' => 1]);
    $existing = Reminder::factory()->create([
        'remindable_id' => $journal->entity->id,
        'remindable_type' => Entity::class,
        'calendar_id' => $calendar->id,
        'type_id' => EntityEventTypes::calendarDate,
    ]);

    $newReminder = Reminder::factory()->create([
        'remindable_id' => $journal->entity->id,
        'remindable_type' => Entity::class,
        'calendar_id' => $calendar->id,
    ]);

    expect($newReminder->fresh()->type_id)->toBeNull()
        ->and($journal->entity->fresh()->calendarDate->is($existing))->toBeTrue();

    $character = Character::factory()->create(['campaign_id' => 1]);
    $characterReminder = Reminder::factory()->create([
        'remindable_id' => $character->entity->id,
        'remindable_type' => Entity::class,
        'calendar_id' => $calendar->id,
    ]);

    expect($characterReminder->fresh()->type_id)->toBeNull();
});

<?php

use App\Enums\EntityEventTypes;
use App\Enums\Visibility;
use App\Models\Calendar;
use App\Models\Campaign;
use App\Models\CampaignPermission;
use App\Models\CampaignSetting;
use App\Models\Character;
use App\Models\Family;
use App\Models\Location;
use App\Models\Organisation;
use App\Rules\EntryDates;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {
    $this->asUser()->withCampaign();
    $this->calendar = Calendar::factory()->create(['campaign_id' => 1, 'date' => '1200-6-15']);
});

function entryDatePayload(Calendar $calendar, int $year = 1000): array
{
    return ['calendar_id' => $calendar->id, 'year' => $year, 'month' => 2, 'day' => 15];
}

it('creates birth and death reminders with the character form', function () {
    $this->post(route('characters.store', [1]), [
        'name' => 'Calendar character',
        'age' => 'Unknown',
        'entry_dates' => ['birth' => entryDatePayload($this->calendar), 'death' => entryDatePayload($this->calendar, 1100)],
    ])->assertRedirect()->assertSessionHasNoErrors();

    $character = Character::where('name', 'Calendar character')->firstOrFail();
    expect($character->age)->toBe('Unknown')
        ->and($character->entity->reminders()->count())->toBe(2)
        ->and($character->entity->reminders()->where('type_id', EntityEventTypes::birth)->first()->year)->toBe(1000)
        ->and($character->entity->reminders()->where('type_id', EntityEventTypes::death)->first()->year)->toBe(1100);
});

it('updates existing dates without changing reminder metadata or duplicating them', function () {
    $character = Character::factory()->create(['campaign_id' => 1]);
    $reminder = $character->entity->reminders()->create(entryDatePayload($this->calendar) + [
        'type_id' => EntityEventTypes::birth, 'length' => 1, 'comment' => 'Keep this', 'visibility_id' => Visibility::Admin,
    ]);
    $payload = ['name' => $character->name, 'entry_dates' => ['birth' => entryDatePayload($this->calendar, 1001)]];

    $this->patch(route('entities.update', [1, $character->entity]), $payload)->assertRedirect()->assertSessionHasNoErrors();
    $this->patch(route('entities.update', [1, $character->entity]), $payload)->assertRedirect()->assertSessionHasNoErrors();

    expect($character->entity->reminders()->count())->toBe(1)
        ->and($reminder->fresh()->year)->toBe(1001)
        ->and($reminder->fresh()->comment)->toBe('Keep this')
        ->and($reminder->fresh()->visibility_id)->toBe(Visibility::Admin->value);
});

it('leaves dates untouched when omitted or empty', function () {
    $character = Character::factory()->create(['campaign_id' => 1]);
    $reminder = $character->entity->reminders()->create(entryDatePayload($this->calendar) + ['type_id' => EntityEventTypes::birth, 'length' => 1]);
    foreach ([[], ['entry_dates' => ['birth' => ['calendar_id' => '', 'year' => '', 'month' => '', 'day' => '']]]] as $data) {
        $this->patch(route('entities.update', [1, $character->entity]), ['name' => $character->name] + $data)
            ->assertRedirect()->assertSessionHasNoErrors();
    }
    expect($reminder->fresh()->year)->toBe(1000);
});

it('accepts untouched birth and death fields while editing a character without reminders', function (bool $calendarSelected) {
    $character = Character::factory()->create(['campaign_id' => 1]);
    $empty = ['calendar_id' => '', 'year' => '', 'month' => '', 'day' => ''];
    $death = array_replace($empty, ['calendar_id' => $calendarSelected ? $this->calendar->id : '']);
    $this->post(route('entities.update', [1, $character->entity]), [
        '_method' => 'PATCH',
        'name' => 'Renamed without dates',
        'entry_dates' => ['birth' => $empty, 'death' => $death],
    ])->assertRedirect()->assertSessionHasNoErrors();
    expect($character->entity->reminders()->count())->toBe(0)
        ->and($character->fresh()->name)->toBe('Renamed without dates');
})->with(['empty calendars' => false, 'calendar selected without a date' => true]);

it('preserves existing reminders when only a calendar is submitted', function () {
    $character = Character::factory()->create(['campaign_id' => 1]);
    $reminder = $character->entity->reminders()->create(entryDatePayload($this->calendar) + ['type_id' => EntityEventTypes::birth, 'length' => 1]);
    $calendarOnly = ['calendar_id' => $this->calendar->id, 'year' => '', 'month' => '', 'day' => ''];

    $this->patch(route('entities.update', [1, $character->entity]), [
        'name' => $character->name,
        'entry_dates' => ['birth' => $calendarOnly, 'death' => $calendarOnly],
    ])->assertRedirect()->assertSessionHasNoErrors();

    expect($character->entity->reminders()->count())->toBe(1)
        ->and($reminder->fresh()->year)->toBe(1000);
});

it('accepts empty dates when validating without request middleware', function () {
    $character = Character::factory()->create(['campaign_id' => 1]);
    $empty = ['calendar_id' => '', 'year' => '', 'month' => '', 'day' => ''];
    $validator = Validator::make([
        'entry_dates' => ['birth' => $empty, 'death' => $empty],
    ], [
        'entry_dates' => [new EntryDates($character->entity->campaign, $character->entity->type_id, $character->entity, auth()->user())],
    ]);
    expect($validator->errors()->all())->toBe([]);
});

it('removes only an explicitly selected life date', function () {
    $character = Character::factory()->create(['campaign_id' => 1]);
    foreach ([EntityEventTypes::birth, EntityEventTypes::death] as $type) {
        $character->entity->reminders()->create(entryDatePayload($this->calendar) + ['type_id' => $type, 'length' => 1]);
    }
    $this->patch(route('entities.update', [1, $character->entity]), [
        'name' => $character->name, 'entry_dates' => ['death' => ['remove' => 1]],
    ])->assertRedirect()->assertSessionHasNoErrors();
    expect($character->entity->reminders()->count())->toBe(1)
        ->and($character->entity->reminders()->first()->type_id)->toBe(EntityEventTypes::birth);
});

it('rejects invalid calendar dates before creating a character', function (array $changes) {
    $this->post(route('characters.store', [1]), [
        'name' => 'Invalid dates', 'entry_dates' => ['birth' => array_replace(entryDatePayload($this->calendar), $changes)],
    ])->assertSessionHasErrors('entry_dates');
    expect(Character::where('name', 'Invalid dates')->exists())->toBeFalse();
})->with([
    'missing year' => [['year' => null]],
    'year zero' => [['year' => 0]],
    'month outside calendar' => [['month' => 13]],
    'day outside month' => [['day' => 31]],
    'fractional day' => [['day' => '1.5']],
    'unrecognised calendar' => [['calendar_id' => 99999]],
]);

it('supports leap days according to the selected fantasy calendar', function () {
    $this->post(route('characters.store', [1]), [
        'name' => 'Leap child', 'entry_dates' => ['birth' => ['calendar_id' => $this->calendar->id, 'year' => 1000, 'month' => 2, 'day' => 29]],
    ])->assertRedirect()->assertSessionHasNoErrors();
    expect(Character::where('name', 'Leap child')->firstOrFail()->entity->reminders()->first()->day)->toBe(29);
});

it('rejects a death before an existing birth', function () {
    $character = Character::factory()->create(['campaign_id' => 1]);
    $character->entity->reminders()->create(entryDatePayload($this->calendar) + ['type_id' => EntityEventTypes::birth, 'length' => 1]);
    $this->patch(route('entities.update', [1, $character->entity]), [
        'name' => $character->name, 'entry_dates' => ['death' => entryDatePayload($this->calendar, 999)],
    ])->assertSessionHasErrors('entry_dates');
    expect($character->entity->reminders()->count())->toBe(1);
});

it('refuses to overwrite ambiguous duplicate dates', function () {
    $character = Character::factory()->create(['campaign_id' => 1]);
    for ($i = 0; $i < 2; $i++) {
        $character->entity->reminders()->create(entryDatePayload($this->calendar) + ['type_id' => EntityEventTypes::birth, 'length' => 1]);
    }
    $this->patch(route('entities.update', [1, $character->entity]), [
        'name' => $character->name, 'entry_dates' => ['birth' => entryDatePayload($this->calendar, 1001)],
    ])->assertSessionHasErrors('entry_dates');
    expect($character->entity->reminders()->where('year', 1000)->count())->toBe(2);
});

it('supports founded dates on entries with a founding event', function (string $modelClass) {
    $location = $modelClass::factory()->create(['campaign_id' => 1]);
    $this->patch(route('entities.update', [1, $location->entity]), [
        'name' => $location->name, 'entry_dates' => ['founded' => entryDatePayload($this->calendar)],
    ])->assertRedirect()->assertSessionHasNoErrors();
    expect($location->entity->reminders()->first()->type_id)->toBe(EntityEventTypes::founded);
})->with([Location::class, Family::class, Organisation::class]);

it('rejects calendars from other campaigns', function () {
    $campaign = Campaign::factory()->create();
    $otherCalendar = Calendar::factory()->create(['campaign_id' => $campaign->id]);
    $this->post(route('characters.store', [1]), [
        'name' => 'Foreign calendar', 'entry_dates' => ['birth' => entryDatePayload($otherCalendar)],
    ])->assertSessionHasErrors('entry_dates');
});

it('rejects inline dates when calendars are disabled', function () {
    CampaignSetting::where('campaign_id', 1)->firstOrFail()->update(['calendars' => false]);
    $this->post(route('characters.store', [1]), [
        'name' => 'Disabled calendar', 'entry_dates' => ['birth' => entryDatePayload($this->calendar)],
    ])->assertSessionHasErrors('entry_dates');
});

it('requires calendar editing permission even when the user can create a character', function () {
    $this->asPlayer();
    CampaignPermission::create([
        'campaign_id' => 1, 'campaign_role_id' => 3, 'entity_type_id' => config('entities.ids.character'),
        'action' => CampaignPermission::ACTION_ADD, 'access' => true,
    ]);
    $this->post(route('characters.store', [1]), [
        'name' => 'No calendar permission', 'entry_dates' => ['birth' => entryDatePayload($this->calendar)],
    ])->assertSessionHasErrors('entry_dates');
    expect(Character::where('name', 'No calendar permission')->exists())->toBeFalse();
});

it('copies reminders without duplicating an explicitly edited birth date', function () {
    $source = Character::factory()->create(['campaign_id' => 1]);
    $source->entity->reminders()->create(entryDatePayload($this->calendar) + ['type_id' => EntityEventTypes::birth, 'length' => 1]);
    $this->post(route('characters.store', [1]), [
        'name' => 'Copied birthday', 'copy_source_id' => $source->entity->id, 'copy_reminders' => 1,
        'entry_dates' => ['birth' => entryDatePayload($this->calendar, 1001)],
    ])->assertRedirect()->assertSessionHasNoErrors();
    $copy = Character::where('name', 'Copied birthday')->firstOrFail();
    expect($copy->entity->reminders()->count())->toBe(1)
        ->and($copy->entity->reminders()->first()->year)->toBe(1001)
        ->and($source->entity->reminders()->first()->year)->toBe(1000);
});

it('preserves reminder copying when the inline date inputs are blank', function (bool $calendarSelected) {
    $source = Character::factory()->create(['campaign_id' => 1]);
    $source->entity->reminders()->create(entryDatePayload($this->calendar) + ['type_id' => EntityEventTypes::birth, 'length' => 1]);
    $this->post(route('characters.store', [1]), [
        'name' => 'Unchanged birthday', 'copy_source_id' => $source->entity->id, 'copy_reminders' => 1,
        'entry_dates' => ['birth' => ['calendar_id' => $calendarSelected ? $this->calendar->id : '', 'year' => '', 'month' => '', 'day' => '']],
    ])->assertRedirect()->assertSessionHasNoErrors();
    $copy = Character::where('name', 'Unchanged birthday')->firstOrFail();
    expect($copy->entity->reminders()->count())->toBe(1)
        ->and($copy->entity->reminders()->first()->year)->toBe(1000);
})->with(['empty calendar' => false, 'calendar selected without a date' => true]);

it('uses the existing age calculation as world dates change and stops at death', function () {
    $this->post(route('characters.store', [1]), [
        'name' => 'Aging character',
        'entry_dates' => ['birth' => entryDatePayload($this->calendar), 'death' => entryDatePayload($this->calendar, 1100)],
    ])->assertRedirect()->assertSessionHasNoErrors();
    $entity = Character::where('name', 'Aging character')->firstOrFail()->entity;
    $birth = $entity->reminders()->where('type_id', EntityEventTypes::birth)->first();
    $death = $entity->reminders()->where('type_id', EntityEventTypes::death)->first();

    expect($birth->calcElapsed())->toBe(200)
        ->and($birth->calcElapsed($death))->toBe(100);
    $this->calendar->update(['date' => '1201-6-15']);
    expect($birth->fresh()->calcElapsed())->toBe(201)
        ->and($birth->fresh()->calcElapsed($death))->toBe(100);
});

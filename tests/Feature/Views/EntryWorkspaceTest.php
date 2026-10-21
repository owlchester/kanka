<?php

use App\Enums\EntityEventTypes;
use App\Models\Ability;
use App\Models\Calendar;
use App\Models\CampaignSetting;
use App\Models\Character;
use App\Models\Conversation;
use App\Models\Creature;
use App\Models\Entity;
use App\Models\EntityType;
use App\Models\Event;
use App\Models\Family;
use App\Models\Item;
use App\Models\Journal;
use App\Models\Location;
use App\Models\Map;
use App\Models\Note;
use App\Models\Organisation;
use App\Models\Quest;
use App\Models\Race;
use App\Models\Tag;
use App\Models\Timeline;
use App\Models\User;

beforeEach(function () {
    config(['limits.campaigns.premium' => true]);
    $this->withoutVite();
    User::created(fn (User $user) => $user->saveSettings(['entry_form_layout' => 'modern'])->save());
});

it('uses the writing workspace when creating characters', function () {
    $this->asUser()->withCampaign(['boost_count' => 4]);

    $response = $this->get(route('characters.create', [1]))
        ->assertSuccessful()
        ->assertSee('entry-workspace-columns', false)
        ->assertDontSee('id="entry-description-heading"', false)
        ->assertSee('name="age"', false)
        ->assertSee('name="save_families"', false)
        ->assertSee('field="entity_header_uuid"', false)
        ->assertSee('layout="cover"', false)
        ->assertSee('name="tooltip"', false)
        ->assertDontSee('Their story, in your words.')
        ->assertDontSee(__('fields.header-image.description'))
        ->assertDontSee('id="form-premium"', false);

    expect(substr_count($response->getContent(), 'name="tooltip"'))->toBe(1)
        ->and(substr_count($response->getContent(), 'field="entity_header_uuid"'))->toBe(1);

    expect(strpos($response->getContent(), 'class="field-entry entry"'))
        ->toBeLessThan(strpos($response->getContent(), __('crud.helpers.linking')));
});

it('keeps character metadata and existing editing tools in the workspace', function () {
    $this->asUser()->withCampaign(['boost_count' => 4]);
    $character = Character::factory()->create(['campaign_id' => 1, 'age' => '42']);
    $character->entity->tooltip = 'An unlikely hero';
    $character->entity->save();

    $response = $this->get(route('entities.edit', [1, $character->entity]))
        ->assertSuccessful()
        ->assertSee('entry-workspace-columns', false)
        ->assertSee('value="42"', false)
        ->assertSee('An unlikely hero')
        ->assertSee('id="character-traits-heading"', false)
        ->assertDontSee('id="form-traits"', false)
        ->assertSee('id="form-organisations"', false)
        ->assertSee('id="form-permissions"', false)
        ->assertDontSee('id="form-premium"', false);

    expect(substr_count($response->getContent(), 'name="tooltip"'))->toBe(1)
        ->and(substr_count($response->getContent(), 'field="entity_header_uuid"'))->toBe(1);
});

it('preserves premium gating in the character workspace', function () {
    $this->asUser()->withCampaign();

    $this->get(route('characters.create', [1]))
        ->assertSuccessful()
        ->assertSee('entry-workspace-columns', false)
        ->assertDontSee('name="tooltip"', false)
        ->assertDontSee('entry-workspace-cover', false)
        ->assertDontSee('field="entity_header_uuid"', false);
});

it('keeps the header image visible inside metadata even when one is already set', function () {
    $this->asUser()->withCampaign(['boost_count' => 4]);
    $character = Character::factory()->create(['campaign_id' => 1]);
    $character->entity->header_image = 'campaigns/1/header.jpg';
    $character->entity->saveQuietly();

    $response = $this->get(route('entities.edit', [1, $character->entity]))->assertSuccessful();
    $html = $response->getContent();
    $metadataEnd = strpos($html, '</section>', strpos($html, 'id="entry-metadata-heading"'));

    expect($html)->toContain('id="entry-header-image-heading"')
        ->not->toContain('<details class="entry-workspace-cover')
        ->and(strpos($html, 'entry-workspace-cover'))->toBeGreaterThan(strpos($html, 'id="entry-metadata-heading"'))
        ->and(strpos($html, 'entry-workspace-cover'))->toBeLessThan($metadataEnd)
        ->and(substr_count($html, 'entry-workspace-cover'))->toBe(1);
});

it('offers real calendar dates beside age', function (bool $editing) {
    $this->asUser()->withCampaign();
    Calendar::factory()->create(['campaign_id' => 1]);
    $url = route('characters.create', [1]);
    if ($editing) {
        $character = Character::factory()->create(['campaign_id' => 1]);
        $url = route('entities.edit', [1, $character->entity]);
    }

    $response = $this->get($url)
        ->assertSuccessful()
        ->assertSee('name="age"', false)
        ->assertSee('id="entry-calendar-dates"', false)
        ->assertSee('name="entry_dates[birth][year]"', false)
        ->assertSee('name="entry_dates[death][year]"', false)
        ->assertDontSee('Example calendar');
})->with(['create' => false, 'edit' => true]);

it('keeps age without a dates preview when calendars are disabled', function () {
    $this->asUser()->withCampaign();
    CampaignSetting::where('campaign_id', 1)->firstOrFail()->update(['calendars' => false]);

    $this->get(route('characters.create', [1]))
        ->assertSuccessful()
        ->assertSee('name="age"', false)
        ->assertDontSee('id="entry-calendar-dates"', false);
});

it('provides the calendar current date for birth and death defaults', function () {
    $this->asUser()->withCampaign();
    $calendar = Calendar::factory()->create(['campaign_id' => 1, 'date' => '5530-4-12']);
    $response = $this->get(route('characters.create', [1]))->assertSuccessful();
    preg_match('/data-calendars="([^"]+)"/', $response->getContent(), $matches);
    $options = json_decode(html_entity_decode($matches[1], ENT_QUOTES), true);

    expect($options[$calendar->id]['current'])->toBe(['year' => 5530, 'month' => 4, 'day' => 12])
        ->and($options[$calendar->id]['months'][3])->toBe('April');
});

it('keeps copied character details and copy options', function () {
    $this->asUser()->withCampaign(['boost_count' => 4]);
    $character = Character::factory()->create(['campaign_id' => 1, 'age' => '128']);

    $this->get(route('characters.create', [1, 'copy' => $character->entity->id, 'template' => true]))
        ->assertSuccessful()
        ->assertSee('value="128"', false)
        ->assertSee('id="form-copy"', false);
});

it('prefills copied birth and death dates without offering to remove source reminders', function () {
    $this->asUser()->withCampaign();
    $calendar = Calendar::factory()->create(['campaign_id' => 1]);
    $character = Character::factory()->create(['campaign_id' => 1]);
    foreach (['birth' => 1000, 'death' => 1100] as $key => $year) {
        $character->entity->reminders()->create([
            'calendar_id' => $calendar->id, 'year' => $year, 'month' => 9, 'day' => 10, 'length' => 1,
            'type_id' => $key === 'birth' ? EntityEventTypes::birth : EntityEventTypes::death,
        ]);
    }

    $this->get(route('characters.create', [1, 'copy' => $character->entity->id, 'template' => true]))
        ->assertSuccessful()
        ->assertSee('id="entry-birth-year" type="number" value="1000"', false)
        ->assertSee('id="entry-death-year" type="number" value="1100"', false)
        ->assertSee('showDates: true', false)
        ->assertDontSee('name="entry_dates[birth][remove]"', false)
        ->assertDontSee('name="entry_dates[death][remove]"', false);

    expect($character->entity->reminders()->count())->toBe(2);
});

it('preserves submitted dates instead of replacing them with copied dates after validation', function () {
    $this->asUser()->withCampaign();
    $calendar = Calendar::factory()->create(['campaign_id' => 1]);
    $character = Character::factory()->create(['campaign_id' => 1]);
    $character->entity->reminders()->create([
        'calendar_id' => $calendar->id, 'year' => 1000, 'month' => 1, 'day' => 1, 'length' => 1,
        'type_id' => EntityEventTypes::birth,
    ]);

    $this->withSession(['_old_input' => ['entry_dates' => ['birth' => ['year' => 1001]]]])
        ->get(route('characters.create', [1, 'copy' => $character->entity->id, 'template' => true]))
        ->assertSuccessful()->assertSee('id="entry-birth-year" type="number" value="1001"', false);
});

it('places traits in the inspector before connections without duplicating their fields', function () {
    $this->asUser()->withCampaign();
    $character = Character::factory()->create(['campaign_id' => 1]);
    $response = $this->get(route('entities.edit', [1, $character->entity]))
        ->assertSuccessful()
        ->assertSee('id="character-traits-heading"', false)
        ->assertDontSee('href="#form-traits"', false);
    $html = $response->getContent();

    expect(strpos($html, 'aria-labelledby="character-traits-heading"'))
        ->toBeLessThan(strpos($html, 'aria-labelledby="character-connections-heading"'))
        ->and(substr_count($html, 'id="template_appearance"'))->toBe(1)
        ->and(substr_count($html, 'id="template_personality"'))->toBe(1)
        ->and(substr_count($html, 'name="is_appearance_pinned" value="0"'))->toBe(1);
});

it('keeps the traits tab in the legacy character form', function () {
    $this->asUser()->withCampaign();
    auth()->user()->saveSettings(['entry_form_layout' => 'legacy'])->save();
    $character = Character::factory()->create(['campaign_id' => 1]);

    $this->get(route('entities.edit', [1, $character->entity]))->assertSuccessful()
        ->assertSee('id="form-traits"', false)
        ->assertSee('href="#form-traits"', false)
        ->assertDontSee('entry-workspace-traits', false);
});

it('uses compact outline add buttons and collapsible trait settings in modern forms', function () {
    $this->asUser()->withCampaign();
    $character = Character::factory()->create(['campaign_id' => 1]);
    $response = $this->get(route('entities.edit', [1, $character->entity]))->assertSuccessful();
    $html = $response->getContent();

    expect(substr_count($html, 'data-template="template_appearance"'))->toBe(1)
        ->and(substr_count($html, 'data-template="template_personality"'))->toBe(1)
        ->and(substr_count($html, 'class="btn2 btn-outline btn-sm w-fit dynamic-row-add"'))->toBe(2)
        ->and(substr_count($html, 'class="entry-workspace-trait-settings"'))->toBe(2)
        ->and($html)->toContain('name="is_appearance_pinned"', 'name="is_personality_pinned"', 'name="is_personality_visible"');
});

it('restores submitted character metadata after validation', function () {
    $this->asUser()->withCampaign(['boost_count' => 4]);

    $this->withSession(['_old_input' => ['age' => 'Unknown', 'tooltip' => 'A mysterious stranger']])
        ->get(route('characters.create', [1]))
        ->assertSuccessful()
        ->assertSee('value="Unknown"', false)
        ->assertSee('A mysterious stranger');
});

it('omits disabled modules from the character workspace', function () {
    $this->asUser()->withCampaign();
    CampaignSetting::where('campaign_id', 1)->firstOrFail()->update([
        'families' => false,
        'races' => false,
        'organisations' => false,
    ]);

    $this->get(route('characters.create', [1]))
        ->assertSuccessful()
        ->assertDontSee('id="form-organisations"', false)
        ->assertDontSee('name="save_families"', false)
        ->assertDontSee('name="save_races"', false);
});

it('opens workspace tabs from existing links', function (string $tab, string $pane) {
    $this->asUser()->withCampaign();
    $character = Character::factory()->create(['campaign_id' => 1]);

    $this->get(route('entities.edit', [1, $character->entity, 'tab' => $tab]))
        ->assertSuccessful()
        ->assertSee('active" id="form-' . $pane . '"', false);
})->with([
    'traits' => ['traits', 'entry'],
    'prefixed traits' => ['form-traits', 'entry'],
    'permissions' => ['permissions', 'permissions'],
    'legacy premium' => ['premium', 'entry'],
]);

it('leaves other entity forms unchanged', function () {
    $this->asUser()->withCampaign();
    auth()->user()->saveSettings(['entry_form_layout' => 'legacy'])->save();
    $location = Location::factory()->create(['campaign_id' => 1]);

    $this->get(route('entities.edit', [1, $location->entity]))
        ->assertSuccessful()
        ->assertDontSee('entry-workspace-columns', false)
        ->assertSee('id="form-premium"', false);
});

it('renders modern standard entry forms without duplicating shared fields', function (string $module, string $modelClass) {
    $this->asUser()->withCampaign();
    CampaignSetting::where('campaign_id', 1)->firstOrFail()->update(['conversations' => true, 'dice_rolls' => true]);

    $create = $this->get(route($module . '.create', [1]))->assertSuccessful()->assertSee('entry-workspace', false);
    $model = $modelClass::factory()->create(['campaign_id' => 1]);
    $edit = $this->get(route('entities.edit', [1, $model->entity]))->assertSuccessful()->assertSee('entry-workspace', false);

    foreach ([$create, $edit] as $response) {
        expect(substr_count($response->getContent(), 'name="entry"'))->toBe(1)
            ->and(substr_count($response->getContent(), 'name="save-tags"'))->toBeLessThanOrEqual(1);
    }
})->with([
    ['abilities', Ability::class],
    ['calendars', Calendar::class],
    ['characters', Character::class],
    ['conversations', Conversation::class],
    ['creatures', Creature::class],
    ['events', Event::class],
    ['families', Family::class],
    ['items', Item::class],
    ['journals', Journal::class],
    ['locations', Location::class],
    ['maps', Map::class],
    ['notes', Note::class],
    ['organisations', Organisation::class],
    ['quests', Quest::class],
    ['races', Race::class],
    ['tags', Tag::class],
    ['timelines', Timeline::class],
]);

it('uses the shared modern workspace for custom modules', function () {
    $this->asUser()->withCampaign(['boost_count' => 4]);
    $type = new EntityType(['code' => 'gadget', 'is_special' => true, 'is_enabled' => true]);
    $type->campaign_id = 1;
    $type->singular = 'Gadget';
    $type->plural = 'Gadgets';
    $type->icon = 'fa-solid fa-gear';
    $type->save();
    $entity = new Entity(['campaign_id' => 1, 'name' => 'Custom gadget']);
    $entity->type_id = $type->id;
    $entity->save();

    $this->get(route('entities.create', [1, $type]))->assertSuccessful()
        ->assertSee('entry-workspace', false)->assertSee('Gadget')->assertSee('name="parent_id"', false);
    $this->get(route('entities.edit', [1, $entity]))->assertSuccessful()
        ->assertSee('entry-workspace', false)->assertSee('Custom gadget')->assertSee('name="parent_id"', false);
});

it('uses the shared field label styling for entry members', function (string $module, string $modelClass) {
    $this->asUser()->withCampaign();
    $family = $modelClass::factory()->create(['campaign_id' => 1]);

    foreach ([route($module . '.create', [1]), route('entities.edit', [1, $family->entity])] as $url) {
        $response = $this->get($url)->assertSuccessful();
        expect($response->getContent())->toMatch('/<label[^>]*for="members"[^>]*>\s*<span class="text-xs font-medium opacity-80">/');
    }
})->with([
    'families' => ['families', Family::class],
    'organisations' => ['organisations', Organisation::class],
]);

it('uses the shared field label styling for attribute template auto apply', function () {
    $this->asUser()->withCampaign();
    $response = $this->get(route('attribute_templates.create', [1]))->assertSuccessful();

    expect($response->getContent())->toMatch('/<label[^>]*for="entity_type_id"[^>]*>\s*<span class="text-xs font-medium opacity-80">/');
    $response->assertSee('name="entity_type_id" id="entity_type_id"', false);
});

it('keeps calendar parenting and its helper in overview with a separate settings tab', function (string $layout) {
    $this->asUser()->withCampaign();
    auth()->user()->saveSettings(['entry_form_layout' => $layout])->save();
    $calendar = Calendar::factory()->create(['campaign_id' => 1]);

    foreach ([route('calendars.create', [1]), route('entities.edit', [1, $calendar->entity])] as $url) {
        $response = $this->get($url)->assertSuccessful()
            ->assertSee(__('calendars.hints.parent_calendar'))
            ->assertSee('name="parameters[layout]"', false)
            ->assertDontSee('name="calendar_id"', false);
        $html = $response->getContent();
        expect(substr_count($html, 'name="parent_id"'))->toBe(1)
            ->and($html)->toMatch('/href="#form-calendar"[^>]*>\s*' . preg_quote(__('entries/workspace.settings'), '/') . '\s*<\/a>/');
    }
})->with(['modern', 'legacy']);

it('shows ambiguous birth dates as locked rather than posting over them', function () {
    $this->asUser()->withCampaign();
    $calendar = Calendar::factory()->create(['campaign_id' => 1]);
    $character = Character::factory()->create(['campaign_id' => 1]);
    for ($i = 0; $i < 2; $i++) {
        $character->entity->reminders()->create([
            'calendar_id' => $calendar->id, 'year' => 1000, 'month' => 1, 'day' => 1, 'length' => 1,
            'type_id' => EntityEventTypes::birth,
        ]);
    }
    $this->get(route('entities.edit', [1, $character->entity]))->assertSuccessful()
        ->assertSee(__('entries/workspace.dates.locked'))
        ->assertDontSee('name="entry_dates[birth][year]"', false);
});

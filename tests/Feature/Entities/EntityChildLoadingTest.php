<?php

use App\Enums\Widget;
use App\Jobs\EntityUpdatedJob;
use App\Jobs\EntityWebhookJob;
use App\Livewire\Widgets\EntityListing;
use App\Models\Campaign;
use App\Models\CampaignDashboardWidget;
use App\Models\Character;
use App\Models\Conversation;
use App\Models\ConversationMessage;
use App\Models\ConversationParticipant;
use App\Models\Entity;
use App\Models\EntityType;
use App\Models\Event;
use App\Models\Family;
use App\Models\Journal;
use App\Models\Location;
use App\Models\Map;
use App\Models\Quest;
use App\Models\TimelineElement;
use App\Services\Entity\ColumnDefinitionService;
use App\Services\Entity\Connections\RelatedService;
use App\Services\Entity\StandardEntityCreationService;
use App\Services\Search\LiveSearchService;
use App\Services\Search\TemplateSearchService;
use App\View\Components\Widgets\Previews\Body;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Livewire;

beforeEach(function () {
    $this->asUser()->withCampaign();
    config(['entities.ids.whiteboard' => EntityType::where('code', 'whiteboard')->value('id')]);
});

it('keeps polymorphic pointers in grid projections for every child type', function (string $modelClass) {
    $child = app(StandardEntityCreationService::class)
        ->campaign(Campaign::findOrFail(1))
        ->entityType(EntityType::findOrFail((new $modelClass)->entityTypeId()))
        ->create(['name' => 'Grid child']);

    $entity = Entity::grid()->with('child')->findOrFail($child->entity->id);

    expect($entity->child_type)->toBe($modelClass)
        ->and($entity->child->is($child))->toBeTrue();
})->with('misc models');

it('renders each standard category datagrid using its polymorphic child', function (string $modelClass) {
    $child = app(StandardEntityCreationService::class)
        ->campaign(Campaign::findOrFail(1))
        ->entityType(EntityType::findOrFail((new $modelClass)->entityTypeId()))
        ->create(['name' => 'Listed child']);

    $this->getJson(route('entities.index-api', [1, $child->entity->type_id]))
        ->assertSuccessful()
        ->assertJsonPath('error', false)
        ->assertJsonPath('entities.data.0.id', $child->entity->id);
})->with('misc models');

it('loads the datagrid child graph without typed aliases or per-row queries', function () {
    $family = Family::factory()->create(['campaign_id' => 1]);
    $characters = Character::factory()->count(3)->create(['campaign_id' => 1]);
    foreach ($characters as $character) {
        $character->characterFamilies()->create(['family_id' => $family->id]);
    }
    $type = EntityType::findOrFail(config('entities.ids.character'));
    $relations = app(ColumnDefinitionService::class)->relationMap($type, Campaign::findOrFail(1));
    $entities = Entity::inTypes($type->id)->grid()->with($relations)->get();

    DB::enableQueryLog();
    try {
        foreach ($entities as $entity) {
            expect($entity->relationLoaded('child'))->toBeTrue()
                ->and($entity->child->relationLoaded('characterFamilies'))->toBeTrue()
                ->and($entity->child->characterFamilies->first()->family->entity->id)->toBe($family->entity->id);
        }
        expect(DB::getQueryLog())->toBeEmpty();
    } finally {
        DB::disableQueryLog();
        DB::flushQueryLog();
    }
});

it('loads map placement through the child rather than an unrelated entity alias', function () {
    $location = Location::factory()->create(['campaign_id' => 1]);
    $map = Map::factory()->create(['campaign_id' => 1, 'location_id' => $location->id]);
    $type = $map->entity->entityType;
    $relations = app(ColumnDefinitionService::class)->relationMap($type, Campaign::findOrFail(1));
    $entity = Entity::grid()->with($relations)->findOrFail($map->entity->id);

    expect($entity->child)->toBeInstanceOf(Map::class)
        ->and($entity->child->relationLoaded('location'))->toBeTrue()
        ->and($entity->child->location->entity->id)->toBe($location->entity->id);
});

it('loads location-associated journal quest and family entities through polymorphic children', function () {
    $location = Location::factory()->create(['campaign_id' => 1]);
    $journal = Journal::factory()->create(['campaign_id' => 1]);
    $quest = Quest::factory()->create(['campaign_id' => 1]);
    $family = Family::factory()->create(['campaign_id' => 1]);

    foreach ([$journal, $quest, $family] as $child) {
        DB::table('entity_locations')->insert([
            'entity_id' => $child->entity->id,
            'location_id' => $location->id,
        ]);
    }

    $service = app(RelatedService::class)->entity($location->entity);
    foreach (['loadJournals', 'loadLocationQuests', 'loadFamilies'] as $loader) {
        (new ReflectionMethod(RelatedService::class, $loader))->invoke($service);
    }

    expect($service->connectionsText($journal->entity->id))->toContain(__('entities.journal'))
        ->and($service->connectionsText($quest->entity->id))->toContain(__('entities.quest'))
        ->and($service->connectionsText($family->entity->id))->toContain(__('entities.family'));
});

it('batches API child lookups by concrete type only when the response needs them', function (bool $withImage) {
    Character::factory()->count(3)->create(['campaign_id' => 1]);
    Location::factory()->count(3)->create(['campaign_id' => 1]);

    DB::enableQueryLog();
    try {
        $this->getJson('/api/1.0/campaigns/1/entities' . ($withImage ? '?image=1' : ''))
            ->assertSuccessful();
        $queries = collect(DB::getQueryLog());
        foreach (['characters', 'locations'] as $table) {
            $childQueries = $queries->filter(fn (array $query) => str_starts_with(
                Str::after($query['query'], ' from '),
                '"' . $table . '"',
            ) && ! str_contains($query['query'], 'join "entity_locations"'));
            expect($childQueries)->toHaveCount($withImage ? 1 : 0);
        }
    } finally {
        DB::disableQueryLog();
        DB::flushQueryLog();
    }
})->with([false, true]);

it('keeps recent widget lists lean and loads only the singular preview child', function () {
    Character::factory()->count(3)->create(['campaign_id' => 1]);
    $widget = CampaignDashboardWidget::factory()->create([
        'campaign_id' => 1,
        'widget' => Widget::Recent,
        'config' => ['order' => 'name_asc'],
    ]);

    $entities = $widget->entities();
    foreach ($entities as $entity) {
        expect($entity->child_type)->toBe(Character::class)
            ->and($entity->relationLoaded('child'))->toBeFalse()
            ->and($entity->relationLoaded('status'))->toBeTrue();
    }

    $widget->config = ['singular' => true, 'order' => 'name_asc'];
    $entities = $widget->fresh()->forceFill(['config' => $widget->config])->entities();
    expect($entities->first()->relationLoaded('child'))->toBeTrue()
        ->and($entities->first()->child)->toBeInstanceOf(Character::class)
        ->and($entities->first()->getAttributes())->toHaveKey('entry')
        ->and($entities->getCollection()->get(1)->relationLoaded('child'))->toBeFalse();
});

it('loads distinct widget pages and preserves loading after Livewire hydration', function () {
    Character::factory()->count(12)->sequence(fn ($sequence) => [
        'name' => 'Character ' . str_pad((string) $sequence->index, 2, '0', STR_PAD_LEFT),
    ])->create(['campaign_id' => 1]);
    $widget = CampaignDashboardWidget::factory()->create([
        'campaign_id' => 1,
        'widget' => Widget::Recent,
        'config' => ['order' => 'name_asc'],
    ]);

    $first = $widget->entities(1);
    $second = $widget->entities(2);
    expect($first->count())->toBe(10)
        ->and($second->count())->toBe(2)
        ->and($first->getCollection()->modelKeys())->not->toContain(...$second->getCollection()->modelKeys());

    Livewire::test(EntityListing::class, ['campaign' => Campaign::findOrFail(1), 'widget' => $widget->fresh()])
        ->assertSet('hasMorePages', true)
        ->assertCount('entities', 10)
        ->call('loadEntities')
        ->assertCount('entities', 12)
        ->assertSet('hasMorePages', false);
});

it('uses event dates only from actual event children', function () {
    $event = Event::factory()->create(['campaign_id' => 1, 'date' => 'Event date']);
    $other = Journal::factory()->create(['campaign_id' => 1, 'date' => 'Journal date']);
    $element = new TimelineElement(['date' => 'Fallback', 'use_event_date' => true]);

    $element->setRelation('entity', $event->entity);
    expect($element->displayDate())->toBe('Event date');
    $element->setRelation('entity', $other->entity);
    expect($element->displayDate())->toBe('Fallback');
    $element->setRelation('entity', null);
    expect($element->displayDate())->toBe('Fallback');
});

it('audits physical missing children without flagging retained deleted children', function () {
    $deleted = Character::factory()->create(['campaign_id' => 1]);
    $deleted->entity->delete();
    $missing = Character::factory()->create(['campaign_id' => 1]);
    DB::table('entities')->where('id', $missing->entity->id)->update(['entity_id' => 999999]);
    $unlinked = Character::factory()->create(['campaign_id' => 1]);
    DB::table('entities')->where('id', $unlinked->entity->id)->update(['entity_id' => null, 'child_type' => null]);

    $this->artisan('entities:childless')
        ->expectsOutputToContain('Found 2 childless entities.')
        ->assertSuccessful();
});

it('resolves lookup and template search through the child for underscored category codes', function () {
    $type = EntityType::findOrFail(config('entities.ids.attribute_template'));
    $child = app(StandardEntityCreationService::class)
        ->campaign(Campaign::findOrFail(1))
        ->entityType($type)
        ->create(['name' => 'Property kit', 'is_enabled' => true]);
    $child->entity->updateQuietly(['is_template' => true]);

    $results = app(LiveSearchService::class)
        ->campaign(Campaign::findOrFail(1))
        ->entityType($type)
        ->request(Request::create('/', 'GET'))
        ->search();
    expect($results)->toHaveCount(1)
        ->and($results[0]['id'])->toBe($child->id);

    $templates = app(TemplateSearchService::class)
        ->campaign(Campaign::findOrFail(1))
        ->entityType($type)
        ->request(Request::create('/', 'GET'))
        ->search();
    expect($templates)->toHaveCount(1)
        ->and($templates[0]['id'])->toBe($child->entity->id);
});

it('filters childless entities before limiting template search results', function () {
    $type = EntityType::findOrFail(config('entities.ids.character'));
    $ghosts = Character::factory()->count(12)->create(['campaign_id' => 1]);
    foreach ($ghosts as $ghost) {
        $ghost->entity->updateQuietly(['is_template' => true]);
        DB::table('entities')->where('id', $ghost->entity->id)->update([
            'entity_id' => null,
            'child_type' => null,
        ]);
    }
    $valid = app(StandardEntityCreationService::class)
        ->campaign(Campaign::findOrFail(1))
        ->entityType($type)
        ->create(['name' => 'Valid template']);
    $valid->entity->updateQuietly(['is_template' => true]);

    $templates = app(TemplateSearchService::class)
        ->campaign(Campaign::findOrFail(1))
        ->entityType($type)
        ->request(Request::create('/', 'GET'))
        ->search();

    expect($templates)->toHaveCount(1)
        ->and($templates[0]['id'])->toBe($valid->entity->id);
});

it('hydrates the inverse entity when a child entity is loaded', function () {
    $character = Character::factory()->create(['campaign_id' => 1]);
    $entity = Character::query()->with('entity')->findOrFail($character->id)->entity;

    expect($entity->relationLoaded('child'))
        ->toBeTrue()
        ->and($entity->child->is($character))->toBeTrue();
});

it('restores a loaded morph child and nested child relations from a queued entity', function () {
    $character = Character::factory()->create(['campaign_id' => 1]);
    $family = Family::factory()->create(['campaign_id' => 1]);
    $character->characterFamilies()->create(['family_id' => $family->id]);

    $entity = Entity::with('child.characterFamilies.family.entity')->findOrFail($character->entity->id);
    $job = new EntityWebhookJob($entity, auth()->user(), 1);
    $restored = unserialize(serialize($job));

    expect($restored->entity->relationLoaded('child'))
        ->toBeTrue()
        ->and($restored->entity->child)->toBeInstanceOf(Character::class)
        ->and($restored->entity->child->relationLoaded('characterFamilies'))->toBeTrue()
        ->and($restored->entity->child->characterFamilies->first()->family->entity->id)->toBe($family->entity->id)
        ->and($restored->entity->child->characterFamilies->first()->family->entity->child->is($family))->toBeTrue();
});

it('restores a missing or transformed morph child from a queued entity', function () {
    $character = Character::factory()->create(['campaign_id' => 1]);
    $entity = Entity::with('child')->findOrFail($character->entity->id);
    $missingJob = new EntityWebhookJob($entity, auth()->user(), 1);
    $queuedPayload = serialize($missingJob);

    DB::table('characters')->where('id', $character->id)->delete();
    $missing = unserialize($queuedPayload);
    expect($missing->entity->relationLoaded('child'))->toBeTrue()
        ->and($missing->entity->child)->toBeNull();

    $replacement = Location::factory()->create(['campaign_id' => 1]);
    DB::table('entities')->where('id', $entity->id)->update([
        'entity_id' => $replacement->id,
        'child_type' => Location::class,
        'type_id' => config('entities.ids.location'),
    ]);
    $transformed = unserialize($queuedPayload);

    expect($transformed->entity->child)->toBeInstanceOf(Location::class)
        ->and($transformed->entity->child->is($replacement))->toBeTrue();
});

it('omits unneeded entity relations when serializing the entity update job', function () {
    $character = Character::factory()->create(['campaign_id' => 1]);
    $entity = Entity::with('child')->findOrFail($character->entity->id);
    $job = new EntityUpdatedJob($entity);
    $restored = unserialize(serialize($job));

    expect($restored->entity->relationLoaded('child'))->toBeFalse();
});

it('keeps conversation previews bounded to five messages per child and preloads participant counts', function () {
    $participant = Character::factory()->create(['campaign_id' => 1]);
    foreach (range(1, 2) as $index) {
        $conversation = Conversation::factory()->create(['campaign_id' => 1]);
        ConversationParticipant::factory()->create([
            'conversation_id' => $conversation->id,
            'participant_id' => $participant->entity->id,
        ]);
        ConversationMessage::factory()->count(7)->create([
            'conversation_id' => $conversation->id,
            'participant_id' => $participant->entity->id,
        ]);
        CampaignDashboardWidget::factory()->create([
            'campaign_id' => 1,
            'widget' => Widget::Preview,
            'entity_id' => $conversation->entity->id,
        ]);
    }

    $widgets = CampaignDashboardWidget::positioned()->get();
    foreach ($widgets as $widget) {
        expect($widget->entity->relationLoaded('child'))->toBeTrue()
            ->and($widget->entity->child->participants_count)->toBe(1)
            ->and($widget->entity->child->messages)->toHaveCount(5)
            ->and($widget->entity->child->messages->every(fn ($message) => $message->relationLoaded('participant')))->toBeTrue();
    }
});

it('returns the missing-child diagnostic instead of dereferencing null in API show', function () {
    $child = Character::factory()->create(['campaign_id' => 1]);
    $id = $child->entity->id;
    DB::table('characters')->where('id', $child->id)->delete();

    $this->getJson('/api/1.0/campaigns/1/entities/' . $id)
        ->assertSuccessful()
        ->assertJsonPath('data.child', 'Invalid child, please contact us on Discord with the following: EntityResource for #' . $id);
});

it('prepares sorted visible family members outside the widget template', function () {
    $family = Family::factory()->create(['campaign_id' => 1]);
    $last = Character::factory()->create(['campaign_id' => 1, 'name' => 'Zelda']);
    $first = Character::factory()->create(['campaign_id' => 1, 'name' => 'Adam']);
    $deleted = Character::factory()->create(['campaign_id' => 1, 'name' => 'Deleted']);
    $family->members()->attach([$last->id, $first->id, $deleted->id]);
    $deleted->entity->delete();
    $campaign = Campaign::findOrFail(1)->forceFill(['boost_count' => 1]);
    $widget = new CampaignDashboardWidget([
        'widget' => Widget::Preview,
        'config' => ['members' => '1'],
    ]);

    $view = (new Body($campaign, $widget, $family->entity))->render();
    $members = $view->getData()['members'];

    expect($members->modelKeys())->toBe([$first->id, $last->id])
        ->and($members->every(fn ($member) => $member->relationLoaded('entity')))->toBeTrue();
});

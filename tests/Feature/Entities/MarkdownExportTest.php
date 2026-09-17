<?php

use App\Models\Ability;
use App\Models\Attribute as EntityAttribute;
use App\Models\Character;
use App\Models\CharacterFamily;
use App\Models\CharacterRace;
use App\Models\EntityAbility;
use App\Models\EntityAsset;
use App\Models\Family;
use App\Models\Inventory;
use App\Models\Item;
use App\Models\ItemCreator;
use App\Models\Location;
use App\Models\Organisation;
use App\Models\OrganisationMember;
use App\Models\Race;
use App\Models\Relation;
use App\Models\Tag;
use App\Services\Entity\MarkdownExportService;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

it('uses the request URL for standalone exports and canonical URL for campaign exports', function () {
    $this->asUser()->withCampaign();
    config(['app.url' => 'https://kanka.test']);
    URL::forceRootUrl('http://localhost:1234');

    $organisation = Organisation::factory()->create([
        'campaign_id' => 1,
        'name' => 'Organisation',
    ]);
    $path = '/w/' . $organisation->campaign->slug . '/entities/' . $organisation->entity->id;

    $standalone = app(MarkdownExportService::class)
        ->campaign($organisation->campaign)
        ->entity($organisation->entity)
        ->single()
        ->markdown();
    $campaign = app(MarkdownExportService::class)
        ->campaign($organisation->campaign)
        ->module('organisations')
        ->entity($organisation->entity)
        ->markdown();

    expect($standalone)
        ->toContain('**' . __('export.source') . ':** <http://localhost:1234' . $path . '>')
        ->and($campaign)
        ->toContain('**' . __('export.source') . ':** <https://kanka.test' . $path . '>');
});

it('includes a parent link in standalone markdown exports', function () {
    $this->asUser()->withCampaign();

    $parent = Organisation::factory()->create([
        'campaign_id' => 1,
        'name' => 'Parent organisation',
    ]);
    $child = Organisation::factory()->create([
        'campaign_id' => 1,
        'name' => 'Child organisation',
    ]);
    $child->entity->update(['parent_id' => $parent->entity->id]);

    $markdown = app(MarkdownExportService::class)
        ->campaign($parent->campaign)
        ->entity($child->entity)
        ->single()
        ->markdown();

    expect($markdown)
        ->toContain('**' . __('crud.fields.parent') . ':** [' . $parent->name . '](' . $parent->entity->url() . ')');
});

it('includes a relative parent link in campaign markdown exports', function () {
    $this->asUser()->withCampaign();

    $parent = Organisation::factory()->create([
        'campaign_id' => 1,
        'name' => 'Parent organisation',
    ]);
    $child = Organisation::factory()->create([
        'campaign_id' => 1,
        'name' => 'Child organisation',
    ]);
    $child->entity->update(['parent_id' => $parent->entity->id]);

    $parentLink = '[' . $parent->name . ']('
        . str_replace(' ', '-', $parent->entity->entityType->pluralCode()) . '/'
        . Str::slug($parent->name) . '_' . $parent->entity->id . ')';
    $markdown = app(MarkdownExportService::class)
        ->campaign($parent->campaign)
        ->module('organisations')
        ->entity($child->entity)
        ->markdown();

    expect($markdown)->toContain('**' . __('crud.fields.parent') . ':** ' . $parentLink);
});

it('omits parent metadata for top-level entities', function () {
    $this->asUser()->withCampaign();

    $organisation = Organisation::factory()->create([
        'campaign_id' => 1,
        'name' => 'Top-level organisation',
    ]);
    $markdown = app(MarkdownExportService::class)
        ->campaign($organisation->campaign)
        ->entity($organisation->entity)
        ->single()
        ->markdown();

    expect($markdown)->not->toContain('**' . __('crud.fields.parent') . ':**');
});

it('includes location links in standalone markdown exports', function () {
    $this->asUser()->withCampaign();

    $organisation = Organisation::factory()->create([
        'campaign_id' => 1,
        'name' => 'Organisation',
    ]);
    $location = Location::factory()->create([
        'campaign_id' => 1,
        'name' => 'Location',
    ]);
    $organisation->entity->locations()->attach($location->id);

    $markdown = app(MarkdownExportService::class)
        ->campaign($organisation->campaign)
        ->entity($organisation->entity)
        ->single()
        ->markdown();

    expect($markdown)->toContain('[' . $location->entity->name . '](' . $location->entity->url() . ')');
});

it('keeps location names plain in campaign markdown exports', function () {
    $this->asUser()->withCampaign();

    $organisation = Organisation::factory()->create([
        'campaign_id' => 1,
        'name' => 'Organisation',
    ]);
    $location = Location::factory()->create([
        'campaign_id' => 1,
        'name' => 'Location',
    ]);
    $organisation->entity->locations()->attach($location->id);

    $markdown = app(MarkdownExportService::class)
        ->campaign($organisation->campaign)
        ->module('organisations')
        ->entity($organisation->entity)
        ->markdown();

    expect($markdown)
        ->toContain('**' . __('entities.locations') . ':** ' . $location->entity->name)
        ->not->toContain('[' . $location->entity->name . '](' . $location->entity->url() . ')');
});

it('includes tag colour and icon when exporting a tag', function () {
    $this->asUser()->withCampaign();

    $tag = Tag::factory()->create([
        'campaign_id' => 1,
        'name' => 'Important',
        'colour' => '#123456',
        'icon' => 'fa-solid fa-star',
    ]);

    $markdown = app(MarkdownExportService::class)
        ->campaign($tag->campaign)
        ->single()
        ->entity($tag->entity)
        ->markdown();

    expect($markdown)
        ->toContain('**' . __('crud.fields.colour') . ':** #123456')
        ->toContain('**' . __('tags.fields.icon') . ':** fa-solid fa-star');
});

it('skips deleted item creators in markdown exports', function () {
    $this->asUser()->withCampaign();

    $item = Item::factory()->create(['campaign_id' => 1]);
    $creator = Organisation::factory()->create(['campaign_id' => 1]);
    ItemCreator::create([
        'item_id' => $item->id,
        'creator_id' => $creator->entity->id,
    ]);
    $creator->entity->delete();

    $markdown = app(MarkdownExportService::class)
        ->campaign($item->campaign)
        ->entity($item->entity)
        ->single()
        ->markdown();

    expect($markdown)->not->toContain(__('items.fields.creators'));
});

it('includes abilities, attributes, inventory and media in standalone exports', function () {
    $this->asUser()->withCampaign();

    $organisation = Organisation::factory()->create([
        'campaign_id' => 1,
        'name' => 'Silver Guard',
    ]);
    $ability = Ability::factory()->create([
        'campaign_id' => 1,
        'name' => 'Arcane Bolt',
        'charges' => 3,
    ]);
    $ability->entity->update(['entry' => '<p>A bolt of energy.</p><p>It travels in a straight line.</p>']);
    EntityAbility::create([
        'entity_id' => $organisation->entity->id,
        'ability_id' => $ability->id,
        'charges' => 1,
        'note' => "Only use this at range.\nRequires focus.",
    ]);
    EntityAttribute::create([
        'entity_id' => $organisation->entity->id,
        'name' => 'Might',
        'value' => '18',
        'type_id' => 1,
        'is_private' => false,
        'is_hidden' => false,
    ]);
    Inventory::create([
        'entity_id' => $organisation->entity->id,
        'name' => 'Healing potion',
        'amount' => 2,
        'position' => 'Satchel',
        'description' => 'Restores health.',
    ]);
    EntityAsset::factory()->create([
        'entity_id' => $organisation->entity->id,
        'type_id' => 2,
        'name' => 'Campaign wiki',
        'metadata' => ['url' => 'https://example.test/wiki'],
    ]);
    EntityAsset::factory()->create([
        'entity_id' => $organisation->entity->id,
        'type_id' => 1,
        'name' => 'Campaign guide',
        'metadata' => [
            'path' => 'files/campaign-guide.pdf',
            'type' => 'application/pdf',
        ],
    ]);

    $markdown = app(MarkdownExportService::class)
        ->campaign($organisation->campaign)
        ->entity($organisation->entity)
        ->single()
        ->markdown();

    expect($markdown)
        ->toContain('## ' . __('entities.abilities'))
        ->toContain('**[Arcane Bolt](' . $ability->entity->url() . ')**')
        ->toContain('**' . __('abilities.fields.charges') . ':** 1 / 3')
        ->toContain("```\nA bolt of energy.\n\nIt travels in a straight line.\n```")
        ->toContain("```\n**Note:** Only use this at range.  \nRequires focus.\n```")
        ->toContain('## ' . __('entries/tabs.properties'))
        ->toContain('**Might**: 18')
        ->toContain('## ' . __('crud.tabs.inventory'))
        ->toContain('Healing potion')
        ->toContain('Restores health.')
        ->toContain('## ' . __('entities/files.fields.files'))
        ->toContain('Campaign wiki')
        ->toContain('https://example.test/wiki')
        ->toContain('Campaign guide')
        ->toContain('campaign-guide.pdf');
});

it('links abilities to their markdown files in campaign exports', function () {
    $this->asUser()->withCampaign();

    $organisation = Organisation::factory()->create([
        'campaign_id' => 1,
        'name' => 'Silver Guard',
    ]);
    $ability = Ability::factory()->create([
        'campaign_id' => 1,
        'name' => 'Arcane Bolt',
    ]);
    EntityAbility::create([
        'entity_id' => $organisation->entity->id,
        'ability_id' => $ability->id,
    ]);

    $markdown = app(MarkdownExportService::class)
        ->campaign($organisation->campaign)
        ->module('organisations')
        ->entity($organisation->entity)
        ->markdown();

    expect($markdown)->toContain(
        '[Arcane Bolt](abilities/' . Str::slug($ability->name) . '_' . $ability->entity->id . '.md)'
    );
});

it('places character profile details before utility sections', function () {
    $this->asUser()->withCampaign();

    $character = Character::factory()->create([
        'campaign_id' => 1,
        'name' => 'Aster Vale',
        'title' => 'Captain',
        'age' => '42',
    ]);
    $ability = Ability::factory()->create([
        'campaign_id' => 1,
        'name' => 'Tactical Command',
    ]);
    EntityAbility::create([
        'entity_id' => $character->entity->id,
        'ability_id' => $ability->id,
    ]);
    Inventory::create([
        'entity_id' => $character->entity->id,
        'name' => 'Field journal',
        'amount' => 1,
    ]);
    EntityAsset::factory()->create([
        'entity_id' => $character->entity->id,
        'type_id' => 2,
        'name' => 'Character notes',
        'metadata' => ['url' => 'https://example.test/aster'],
    ]);

    $markdown = app(MarkdownExportService::class)
        ->campaign($character->campaign)
        ->entity($character->entity)
        ->single()
        ->markdown();
    $profile = strpos($markdown, '## ' . __('crud.tabs.profile'));
    $abilities = strpos($markdown, '## ' . __('entities.abilities'));
    $inventory = strpos($markdown, '## ' . __('crud.tabs.inventory'));
    $assets = strpos($markdown, '## ' . __('entities/files.fields.files'));

    expect($markdown)
        ->toContain('**' . __('characters.fields.title') . '** Captain')
        ->toContain('**' . __('characters.fields.age') . '** 42')
        ->and($profile)->toBeLessThan($abilities)
        ->and($abilities)->toBeLessThan($inventory)
        ->and($inventory)->toBeLessThan($assets);
});

it('includes linked character families races and organisations in standalone markdown exports', function () {
    $this->asUser()->withCampaign();

    $character = Character::factory()->create(['campaign_id' => 1, 'name' => 'Character']);
    $family = Family::factory()->create(['campaign_id' => 1, 'name' => 'House Storm']);
    $race = Race::factory()->create(['campaign_id' => 1, 'name' => 'Moon Elf']);
    $organisation = Organisation::factory()->create(['campaign_id' => 1, 'name' => 'Silver Guard']);
    $deletedOrganisation = Organisation::factory()->create(['campaign_id' => 1, 'name' => 'Forgotten Guard']);
    $location = Location::factory()->create(['campaign_id' => 1, 'name' => 'Moon Harbour']);

    $character->entity->locations()->attach($location->id);
    CharacterFamily::create(['character_id' => $character->id, 'family_id' => $family->id]);
    CharacterFamily::create(['character_id' => $character->id, 'family_id' => $family->id]);
    CharacterRace::create(['character_id' => $character->id, 'race_id' => $race->id]);
    CharacterRace::create(['character_id' => $character->id, 'race_id' => $race->id]);
    OrganisationMember::create([
        'character_id' => $character->id,
        'organisation_id' => $organisation->id,
        'role' => 'Captain',
    ]);
    OrganisationMember::create([
        'character_id' => $character->id,
        'organisation_id' => $deletedOrganisation->id,
    ]);
    $deletedOrganisation->entity->delete();

    $markdown = app(MarkdownExportService::class)
        ->campaign($character->campaign)
        ->entity($character->entity)
        ->single()
        ->markdown();

    expect($markdown)
        ->toContain('## ' . __('crud.tabs.profile'))
        ->toContain('[' . $family->name . '](' . $family->entity->url() . ')')
        ->toContain('[' . $race->name . '](' . $race->entity->url() . ')')
        ->toContain('[' . $organisation->name . '](' . $organisation->entity->url() . ') (Captain)')
        ->not->toContain($deletedOrganisation->name)
        ->and(substr_count($markdown, $family->entity->url()))->toBe(1)
        ->and(substr_count($markdown, $race->entity->url()))->toBe(1)
        ->and(substr_count($markdown, '## ' . __('crud.tabs.profile')))->toBe(1);
});

it('uses relative links for character details in campaign markdown exports', function () {
    $this->asUser()->withCampaign();

    $character = Character::factory()->create(['campaign_id' => 1, 'name' => 'Character']);
    $family = Family::factory()->create(['campaign_id' => 1, 'name' => 'House Storm']);
    $race = Race::factory()->create(['campaign_id' => 1, 'name' => 'Moon Elf']);
    $organisation = Organisation::factory()->create(['campaign_id' => 1, 'name' => 'Silver Guard']);

    CharacterFamily::create(['character_id' => $character->id, 'family_id' => $family->id]);
    CharacterRace::create(['character_id' => $character->id, 'race_id' => $race->id]);
    OrganisationMember::create([
        'character_id' => $character->id,
        'organisation_id' => $organisation->id,
    ]);

    $markdown = app(MarkdownExportService::class)
        ->campaign($character->campaign)
        ->module('characters')
        ->entity($character->entity)
        ->markdown();

    expect($markdown)
        ->toContain('[' . $family->name . '](families/' . Str::slug($family->name) . '_' . $family->entity->id . ')')
        ->toContain('[' . $race->name . '](races/' . Str::slug($race->name) . '_' . $race->entity->id . ')')
        ->toContain('[' . $organisation->name . '](organisations/' . Str::slug($organisation->name) . '_' . $organisation->entity->id . ')')
        ->not->toContain($organisation->name . ' ()');
});

it('includes relationship roles in standalone and campaign markdown exports', function () {
    $this->asUser()->withCampaign();

    $owner = Organisation::factory()->create(['campaign_id' => 1, 'name' => 'Silver Guard']);
    $target = Character::factory()->create(['campaign_id' => 1, 'name' => 'Aster Vale']);
    Relation::create([
        'campaign_id' => 1,
        'owner_id' => $owner->entity->id,
        'target_id' => $target->entity->id,
        'relation' => 'Protects and guides',
    ]);

    $standalone = app(MarkdownExportService::class)
        ->campaign($owner->campaign)
        ->entity($owner->entity)
        ->single()
        ->markdown();
    $campaign = app(MarkdownExportService::class)
        ->campaign($owner->campaign)
        ->module('organisations')
        ->entity($owner->entity)
        ->markdown();

    expect($standalone)
        ->toContain('* **Protects and guides**: [' . $target->name . '](' . $target->entity->url() . ')')
        ->and($campaign)
        ->toContain('* **Protects and guides**: [' . $target->name . '](characters/' . Str::slug($target->name) . '_' . $target->entity->id . ')');
});

it('uses each direction role for mirrored relationships', function () {
    $this->asUser()->withCampaign();

    $parent = Character::factory()->create(['campaign_id' => 1, 'name' => 'Parent']);
    $child = Character::factory()->create(['campaign_id' => 1, 'name' => 'Child']);
    $parentRelation = Relation::create([
        'campaign_id' => 1,
        'owner_id' => $parent->entity->id,
        'target_id' => $child->entity->id,
        'relation' => 'Parent of',
    ]);
    $childRelation = Relation::create([
        'campaign_id' => 1,
        'owner_id' => $child->entity->id,
        'target_id' => $parent->entity->id,
        'relation' => 'Child of',
        'mirror_id' => $parentRelation->id,
    ]);
    $parentRelation->update(['mirror_id' => $childRelation->id]);

    $parentMarkdown = app(MarkdownExportService::class)
        ->campaign($parent->campaign)
        ->entity($parent->entity)
        ->single()
        ->markdown();
    $childMarkdown = app(MarkdownExportService::class)
        ->campaign($child->campaign)
        ->entity($child->entity)
        ->single()
        ->markdown();

    expect($parentMarkdown)
        ->toContain('**Parent of**')
        ->not->toContain('**Child of**')
        ->and($childMarkdown)
        ->toContain('**Child of**')
        ->not->toContain('**Parent of**');
});

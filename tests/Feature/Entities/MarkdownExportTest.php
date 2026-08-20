<?php

use App\Models\Location;
use App\Models\Organisation;
use App\Models\Tag;
use App\Services\Entity\MarkdownExportService;
use Illuminate\Support\Str;

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

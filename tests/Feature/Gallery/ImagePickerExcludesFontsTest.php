<?php

use App\Enums\Widget;
use App\Models\Campaign;
use App\Models\Image;

it('excludes font files and folders from the images.find picker', function () {
    $this->asUser()->withCampaign();
    $campaign = Campaign::find(1);

    $png = Image::factory()->create(['campaign_id' => $campaign->id, 'name' => 'Banner PNG', 'ext' => 'png']);
    $webp = Image::factory()->create(['campaign_id' => $campaign->id, 'name' => 'Banner WEBP', 'ext' => 'webp']);
    $svg = Image::factory()->create(['campaign_id' => $campaign->id, 'name' => 'Icon SVG', 'ext' => 'svg']);
    $woff = Image::factory()->create(['campaign_id' => $campaign->id, 'name' => 'Legacy Font', 'ext' => 'woff']);
    $woff2 = Image::factory()->create(['campaign_id' => $campaign->id, 'name' => 'Custom Font', 'ext' => 'woff2']);
    $folder = Image::factory()->create(['campaign_id' => $campaign->id, 'name' => 'Assets Folder', 'is_folder' => true, 'ext' => null]);

    $response = $this->getJson(route('images.find', $campaign))
        ->assertOk();

    $ids = collect($response->json())->pluck('id')->all();

    expect($ids)
        ->toContain($png->id, $webp->id, $svg->id)
        ->not->toContain($woff->id, $woff2->id, $folder->id);
});

it('excludes font files from gallery.browse while keeping folders and excluding fonts from folder image_count', function () {
    $this->asUser()->withCampaign();
    $campaign = Campaign::find(1);

    $folder = Image::factory()->create([
        'campaign_id' => $campaign->id,
        'name' => 'Campaign Assets',
        'is_folder' => true,
        'ext' => null,
    ]);
    $rootPng = Image::factory()->create(['campaign_id' => $campaign->id, 'name' => 'Root Image', 'ext' => 'png']);
    $rootWoff = Image::factory()->create(['campaign_id' => $campaign->id, 'name' => 'Root Woff', 'ext' => 'woff']);
    $rootWoff2 = Image::factory()->create(['campaign_id' => $campaign->id, 'name' => 'Root Woff2', 'ext' => 'woff2']);

    Image::factory()->create([
        'campaign_id' => $campaign->id,
        'folder_id' => $folder->id,
        'name' => 'Nested Image',
        'ext' => 'png',
    ]);
    Image::factory()->create([
        'campaign_id' => $campaign->id,
        'folder_id' => $folder->id,
        'name' => 'Nested Font',
        'ext' => 'woff2',
    ]);

    $response = $this->getJson(route('gallery.browse', $campaign))
        ->assertOk();

    $items = collect($response->json('images'));
    $uuids = $items->pluck('uuid')->all();

    expect($uuids)
        ->toContain($folder->id, $rootPng->id)
        ->not->toContain($rootWoff->id, $rootWoff2->id);

    $folderItem = $items->firstWhere('uuid', $folder->id);
    expect($folderItem['image_count'])->toBe(1);
});

it('excludes font files from gallery.tiptap while keeping folders', function () {
    $this->asUser()->withCampaign();
    $campaign = Campaign::find(1);

    $folder = Image::factory()->create([
        'campaign_id' => $campaign->id,
        'name' => 'Tiptap Folder',
        'is_folder' => true,
        'ext' => null,
    ]);
    $png = Image::factory()->create(['campaign_id' => $campaign->id, 'name' => 'Tiptap Image', 'ext' => 'png']);
    $woff = Image::factory()->create(['campaign_id' => $campaign->id, 'name' => 'Tiptap Woff', 'ext' => 'woff']);
    $woff2 = Image::factory()->create(['campaign_id' => $campaign->id, 'name' => 'Tiptap Woff2', 'ext' => 'woff2']);

    $response = $this->getJson(route('gallery.tiptap', $campaign))
        ->assertOk();

    $uuids = collect($response->json('data'))->pluck('uuid')->all();

    expect($uuids)
        ->toContain($folder->id, $png->id)
        ->not->toContain($woff->id, $woff2->id);
});

it('rejects font files and accepts images for header widget config.image_uuid', function () {
    $this->asUser()->withCampaign();
    $campaign = Campaign::find(1);

    $font = Image::factory()->create(['campaign_id' => $campaign->id, 'name' => 'Header Font', 'ext' => 'woff2']);
    $image = Image::factory()->create(['campaign_id' => $campaign->id, 'name' => 'Header Image', 'ext' => 'png']);

    $this->post(route('campaign_dashboard_widgets.store', $campaign), [
        'widget' => Widget::Header->value,
        'config' => [
            'image_uuid' => $font->id,
        ],
    ])->assertSessionHasErrors('config.image_uuid');

    $this->post(route('campaign_dashboard_widgets.store', $campaign), [
        'widget' => Widget::Header->value,
        'config' => [
            'image_uuid' => $image->id,
        ],
    ])->assertSessionDoesntHaveErrors('config.image_uuid');
});

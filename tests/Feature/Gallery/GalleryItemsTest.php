<?php

use App\Models\Character;
use App\Models\EntityAsset;
use App\Models\Image;
use App\Models\ImageMention;
use App\Models\Inventory;
use App\Models\Map;
use App\Models\MapLayer;

it('paginates gallery items and returns pagination metadata', function () {
    $this->asUser()->withCampaign();

    Image::factory()->count(30)->create([
        'campaign_id' => 1,
        'is_folder' => false,
    ]);

    $this->getJson(route('gallery.items', ['test-campaign', 'per_page' => 24]))
        ->assertOk()
        ->assertJsonCount(24, 'files')
        ->assertJsonPath('pagination.total', 30)
        ->assertJsonPath('pagination.last_page', 2)
        ->assertJsonPath('pagination.from', 1)
        ->assertJsonPath('pagination.to', 24);

    $this->getJson(route('gallery.items', ['test-campaign', 'per_page' => 24, 'page' => 2]))
        ->assertOk()
        ->assertJsonCount(6, 'files')
        ->assertJsonPath('pagination.current_page', 2);
});

it('searches across name, description, author, and ext with folder or global scope', function () {
    $this->asUser()->withCampaign();

    $folder = Image::factory()->create(['campaign_id' => 1, 'is_folder' => true, 'name' => 'Maps']);
    Image::factory()->create(['campaign_id' => 1, 'name' => 'Dragon Keep', 'description' => 'Volcano lair', 'author' => 'Alice', 'ext' => 'png', 'folder_id' => $folder->id]);
    Image::factory()->create(['campaign_id' => 1, 'name' => 'Tavern', 'description' => 'Cozy inn', 'author' => 'Bob', 'ext' => 'webp']);

    // Global search by author
    $this->getJson(route('gallery.items', ['test-campaign', 'q' => 'Alice', 'scope' => 'all']))
        ->assertOk()
        ->assertJsonCount(1, 'files')
        ->assertJsonPath('files.0.name', 'Dragon Keep');

    // Folder-scoped search at root should not find item inside $folder
    $this->getJson(route('gallery.items', ['test-campaign', 'q' => 'Volcano', 'scope' => 'folder']))
        ->assertOk()
        ->assertJsonCount(0, 'files');

    // Folder-scoped search inside $folder finds it
    $this->getJson(route('gallery.items', ['test-campaign', 'folder' => $folder->id, 'q' => 'Volcano', 'scope' => 'folder']))
        ->assertOk()
        ->assertJsonCount(1, 'files');
});

it('accurately filters unused and used images across all 7 usage sources', function () {
    $this->asUser()->withCampaign();

    $unused = Image::factory()->create(['campaign_id' => 1, 'name' => 'Unused Art']);
    $usedEntityImg = Image::factory()->create(['campaign_id' => 1, 'name' => 'Entity Portrait']);
    $usedHeader = Image::factory()->create(['campaign_id' => 1, 'name' => 'Entity Header']);
    $usedMention = Image::factory()->create(['campaign_id' => 1, 'name' => 'Entry Mention']);
    $usedAsset = Image::factory()->create(['campaign_id' => 1, 'name' => 'Asset Img']);
    $usedLayer = Image::factory()->create(['campaign_id' => 1, 'name' => 'Map Layer Img']);
    $usedInventory = Image::factory()->create(['campaign_id' => 1, 'name' => 'Inventory Img']);
    $usedDefault = Image::factory()->create(['campaign_id' => 1, 'name' => 'Default Placeholder', 'is_default' => true]);

    $character = Character::factory()->create(['campaign_id' => 1]);
    $entity = $character->entity;
    $entity->update(['image_uuid' => $usedEntityImg->id, 'header_uuid' => $usedHeader->id]);
    ImageMention::create(['entity_id' => $entity->id, 'image_id' => $usedMention->id]);
    EntityAsset::create(['entity_id' => $entity->id, 'name' => 'Audio', 'type_id' => 1, 'image_uuid' => $usedAsset->id, 'metadata' => []]);

    $map = Map::factory()->create(['campaign_id' => 1]);
    MapLayer::create(['map_id' => $map->id, 'name' => 'Base', 'image_uuid' => $usedLayer->id, 'position' => 1]);
    Inventory::create(['entity_id' => $entity->id, 'name' => 'Sword', 'amount' => 1, 'image_uuid' => $usedInventory->id]);

    $this->getJson(route('gallery.items', ['test-campaign', 'usage' => 'unused', 'scope' => 'all']))
        ->assertOk()
        ->assertJsonCount(1, 'files')
        ->assertJsonPath('files.0.id', $unused->id);

    $this->getJson(route('gallery.items', ['test-campaign', 'usage' => 'used', 'scope' => 'all']))
        ->assertOk()
        ->assertJsonCount(7, 'files');
});

it('filters by type and orientation and sorts items', function () {
    $this->asUser()->withCampaign();

    Image::factory()->create([
        'campaign_id' => 1,
        'name' => 'Beta Landscape',
        'ext' => 'png',
        'size' => 500,
        'metadata' => ['width' => 1920, 'height' => 1080],
    ]);
    Image::factory()->create([
        'campaign_id' => 1,
        'name' => 'Alpha Font',
        'ext' => 'woff2',
        'size' => 100,
    ]);
    Image::factory()->create([
        'campaign_id' => 1,
        'name' => 'Gamma Vector',
        'ext' => 'svg',
        'size' => 50,
        'metadata' => ['width' => 500, 'height' => 500],
    ]);

    $this->getJson(route('gallery.items', ['test-campaign', 'type' => 'font']))
        ->assertOk()
        ->assertJsonCount(1, 'files')
        ->assertJsonPath('files.0.name', 'Alpha Font');

    $this->getJson(route('gallery.items', ['test-campaign', 'orientation' => 'landscape']))
        ->assertOk()
        ->assertJsonCount(1, 'files')
        ->assertJsonPath('files.0.name', 'Beta Landscape');

    $this->getJson(route('gallery.items', ['test-campaign', 'orientation' => 'square']))
        ->assertOk()
        ->assertJsonCount(1, 'files')
        ->assertJsonPath('files.0.name', 'Gamma Vector');

    $this->getJson(route('gallery.items', ['test-campaign', 'sort' => 'size_desc']))
        ->assertOk()
        ->assertJsonPath('files.0.name', 'Beta Landscape')
        ->assertJsonPath('files.2.name', 'Gamma Vector');
});

it('sorts by used_desc, used_asc, and updated_asc', function () {
    $this->asUser()->withCampaign();

    $unused = Image::factory()->create([
        'campaign_id' => 1,
        'name' => 'Unused Img',
        'updated_at' => now()->subDays(3),
    ]);
    $usedOnce = Image::factory()->create([
        'campaign_id' => 1,
        'name' => 'Used Once',
        'updated_at' => now()->subDay(),
    ]);
    $usedTwice = Image::factory()->create([
        'campaign_id' => 1,
        'name' => 'Used Twice',
        'updated_at' => now()->subDays(2),
    ]);

    $char = Character::factory()->create(['campaign_id' => 1]);
    $char->entity->update(['image_uuid' => $usedOnce->id, 'header_uuid' => $usedTwice->id]);
    ImageMention::create(['entity_id' => $char->entity->id, 'image_id' => $usedTwice->id]);

    $this->getJson(route('gallery.items', ['test-campaign', 'sort' => 'used_desc']))
        ->assertOk()
        ->assertJsonPath('files.0.id', $usedTwice->id)
        ->assertJsonPath('files.1.id', $usedOnce->id)
        ->assertJsonPath('files.2.id', $unused->id);

    $this->getJson(route('gallery.items', ['test-campaign', 'sort' => 'used_asc']))
        ->assertOk()
        ->assertJsonPath('files.0.id', $unused->id);

    $this->getJson(route('gallery.items', ['test-campaign', 'sort' => 'updated_asc']))
        ->assertOk()
        ->assertJsonPath('files.0.id', $unused->id);
});

it('returns unlimited-depth breadcrumbs and hydrates deep-linked selected_image', function () {
    $this->asUser()->withCampaign();

    $f1 = Image::factory()->create(['campaign_id' => 1, 'is_folder' => true, 'name' => 'Level 1']);
    $f2 = Image::factory()->create(['campaign_id' => 1, 'is_folder' => true, 'name' => 'Level 2', 'folder_id' => $f1->id]);
    $f3 = Image::factory()->create(['campaign_id' => 1, 'is_folder' => true, 'name' => 'Level 3', 'folder_id' => $f2->id]);
    $f4 = Image::factory()->create(['campaign_id' => 1, 'is_folder' => true, 'name' => 'Level 4', 'folder_id' => $f3->id]);
    $img = Image::factory()->create(['campaign_id' => 1, 'is_folder' => false, 'name' => 'Deep Art', 'folder_id' => $f4->id]);

    $this->getJson(route('gallery.items', ['test-campaign', 'folder' => $f4->id, 'image' => $img->id]))
        ->assertOk()
        ->assertJsonCount(3, 'breadcrumbs')
        ->assertJsonPath('breadcrumbs.0.name', 'Level 1')
        ->assertJsonPath('breadcrumbs.1.name', 'Level 2')
        ->assertJsonPath('breadcrumbs.2.name', 'Level 3')
        ->assertJsonPath('selected_image.id', $img->id);
});

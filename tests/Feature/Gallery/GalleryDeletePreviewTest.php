<?php

use App\Models\Character;
use App\Models\EntityAsset;
use App\Models\Image;
use App\Models\ImageMention;

it('returns recursive folder counts and entry mention warnings on delete preview', function () {
    $this->asUser()->withCampaign();

    $folder = Image::factory()->create(['campaign_id' => 1, 'is_folder' => true, 'name' => 'Characters']);
    $subfolder = Image::factory()->create(['campaign_id' => 1, 'is_folder' => true, 'name' => 'NPCs', 'folder_id' => $folder->id]);
    $img1 = Image::factory()->create(['campaign_id' => 1, 'size' => 1024, 'name' => 'Innkeeper', 'folder_id' => $subfolder->id]);
    $img2 = Image::factory()->create(['campaign_id' => 1, 'size' => 512, 'name' => 'Guard', 'folder_id' => $folder->id]);

    $character = Character::factory()->create(['campaign_id' => 1, 'name' => 'The Rusty Mug']);
    $entity = $character->entity;
    $entity->update(['image_uuid' => $img2->id]);
    ImageMention::create(['entity_id' => $entity->id, 'image_id' => $img1->id]);
    EntityAsset::create(['entity_id' => $entity->id, 'name' => 'Token', 'type_id' => 1, 'image_uuid' => $img2->id, 'metadata' => []]);

    $this->postJson(route('gallery.delete-preview', 'test-campaign'), [
        'images' => [$folder->id],
    ])
        ->assertOk()
        ->assertJsonPath('total_files', 2)
        ->assertJsonPath('total_folders', 2)
        ->assertJsonPath('total_size_kb', 1536)
        ->assertJsonPath('has_entry_mentions', true)
        ->assertJsonPath('has_impacts', true)
        ->assertJsonCount(1, 'impacts.entry_mentions')
        ->assertJsonCount(1, 'impacts.entity_images')
        ->assertJsonCount(1, 'impacts.entity_assets');
});

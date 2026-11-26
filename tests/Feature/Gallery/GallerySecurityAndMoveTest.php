<?php

use App\Models\Campaign;
use App\Models\CampaignPermission;
use App\Models\CampaignRole;
use App\Models\CampaignRoleUser;
use App\Models\CampaignUser;
use App\Models\Image;
use App\Models\User;
use Illuminate\Http\UploadedFile;

function attachCampaignRoleWithPermissions(Campaign $campaign, User $user, array $actions): void
{
    CampaignUser::create(['campaign_id' => $campaign->id, 'user_id' => $user->id]);
    $role = CampaignRole::create(['campaign_id' => $campaign->id, 'name' => 'Test Role', 'is_admin' => false]);
    CampaignRoleUser::create(['campaign_role_id' => $role->id, 'user_id' => $user->id]);

    foreach ($actions as $action) {
        CampaignPermission::create([
            'campaign_role_id' => $role->id,
            'key' => 'gallery_' . $action,
            'table_name' => 'gallery',
            'action' => $action,
        ]);
    }
}

it('blocks browse-only users from mutating gallery items', function () {
    $owner = User::factory()->create();
    $this->actingAs($owner)->withCampaign();
    $campaign = Campaign::first();

    $image = Image::factory()->create(['campaign_id' => $campaign->id, 'created_by' => $owner->id]);

    $viewer = User::factory()->create();
    attachCampaignRoleWithPermissions($campaign, $viewer, [CampaignPermission::ACTION_GALLERY_BROWSE]);
    $this->actingAs($viewer);

    $this->postJson(route('gallery.create', $campaign), ['name' => 'Hack', 'visibility_id' => 1])
        ->assertForbidden();

    $this->postJson(route('gallery.file.update', [$campaign, $image]), ['name' => 'Renamed'])
        ->assertForbidden();

    $this->deleteJson(route('gallery.file.delete', [$campaign, $image]))
        ->assertForbidden();

    $this->postJson(route('gallery.delete', $campaign), ['images' => [$image->id]])
        ->assertForbidden();

    $this->postJson(route('gallery.file.replace', [$campaign, $image]), ['file' => UploadedFile::fake()->image('x.png')])
        ->assertForbidden();
});

it('allows upload-only users to edit/delete their own images but not others', function () {
    $owner = User::factory()->create();
    $this->actingAs($owner)->withCampaign();
    $campaign = Campaign::first();

    $uploader = User::factory()->create();
    attachCampaignRoleWithPermissions($campaign, $uploader, [
        CampaignPermission::ACTION_GALLERY_BROWSE,
        CampaignPermission::ACTION_GALLERY_UPLOAD,
    ]);

    $otherImage = Image::factory()->create(['campaign_id' => $campaign->id, 'created_by' => $owner->id]);

    $this->actingAs($uploader);
    $ownImage = Image::factory()->create(['campaign_id' => $campaign->id, 'created_by' => $uploader->id]);

    $this->postJson(route('gallery.file.update', [$campaign, $otherImage]), ['name' => 'Nope'])
        ->assertForbidden();

    $this->postJson(route('gallery.file.update', [$campaign, $ownImage]), ['name' => 'Updated Own'])
        ->assertOk()
        ->assertJsonPath('data.name', 'Updated Own');
});

it('prevents moving a folder into itself or a descendant', function () {
    $this->asUser()->withCampaign();

    $parent = Image::factory()->create(['campaign_id' => 1, 'is_folder' => true, 'name' => 'Parent']);
    $child = Image::factory()->create(['campaign_id' => 1, 'is_folder' => true, 'name' => 'Child', 'folder_id' => $parent->id]);

    $this->postJson(route('gallery.update', 'test-campaign'), [
        'files' => [$parent->id],
        'folder_id' => $parent->id,
    ])->assertUnprocessable()->assertJsonValidationErrors('folder_id');

    $this->postJson(route('gallery.update', 'test-campaign'), [
        'files' => [$parent->id],
        'folder_id' => $child->id,
    ])->assertUnprocessable()->assertJsonValidationErrors('folder_id');
});

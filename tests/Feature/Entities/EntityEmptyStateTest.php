<?php

use App\Enums\CampaignVisibility;
use App\Http\Middleware\ReplicationSwitcher;
use App\Models\Campaign;
use App\Models\CampaignPermission;
use App\Models\Character;
use App\Models\Map;
use App\Models\Post;

it('shows both entry and post actions on an empty entity for an admin', function () {
    $this->asUser()->withCampaign();
    $campaign = Campaign::findOrFail(1);
    $character = Character::factory()->create(['campaign_id' => 1]);
    $character->entity->update(['entry' => null]);

    $this->get(route('entities.show', [$campaign, $character->entity]))
        ->assertOk()
        ->assertSee('entity-empty-state')
        ->assertSee(__('entities/story.empty.title', ['name' => $character->name]))
        ->assertSee(route('entities.entry.edit', [$campaign, $character->entity]))
        ->assertSee(__('entities/story.empty.entry.title'))
        ->assertSee(route('entities.posts.create', [$campaign, $character->entity]))
        ->assertSee(__('entities/story.empty.post.title'))
        ->assertDontSee('btn-new-post')
        ->assertDontSee('post-anchor-loader');
});

it('shows both entry and post actions when a player can edit', function () {
    $this->asUser()->withCampaign();
    $campaign = Campaign::findOrFail(1);
    $character = Character::factory()->create(['campaign_id' => 1]);
    $character->entity->update(['entry' => null]);

    CampaignPermission::create([
        'campaign_id' => 1,
        'campaign_role_id' => 3,
        'entity_type_id' => config('entities.ids.character'),
        'action' => CampaignPermission::ACTION_READ,
        'access' => true,
    ]);
    CampaignPermission::create([
        'campaign_id' => 1,
        'campaign_role_id' => 3,
        'entity_type_id' => config('entities.ids.character'),
        'action' => CampaignPermission::ACTION_EDIT,
        'access' => true,
    ]);
    $this->asPlayer();

    $this->get(route('entities.show', [$campaign, $character->entity]))
        ->assertOk()
        ->assertSee('entity-empty-state')
        ->assertSee(route('entities.entry.edit', [$campaign, $character->entity]))
        ->assertSee(route('entities.posts.create', [$campaign, $character->entity]))
        ->assertDontSee(__('entities/story.empty.read_only'));
});

it('shows only the add article action when a player can post but cannot edit', function () {
    $this->asUser()->withCampaign();
    $campaign = Campaign::findOrFail(1);
    $character = Character::factory()->create(['campaign_id' => 1]);
    $character->entity->update(['entry' => null]);

    CampaignPermission::create([
        'campaign_id' => 1,
        'campaign_role_id' => 3,
        'entity_type_id' => config('entities.ids.character'),
        'action' => CampaignPermission::ACTION_READ,
        'access' => true,
    ]);
    CampaignPermission::create([
        'campaign_id' => 1,
        'campaign_role_id' => 3,
        'entity_type_id' => config('entities.ids.character'),
        'action' => CampaignPermission::ACTION_POSTS,
        'access' => true,
    ]);
    $this->asPlayer();

    $this->get(route('entities.show', [$campaign, $character->entity]))
        ->assertOk()
        ->assertSee('entity-empty-state')
        ->assertSee(route('entities.posts.create', [$campaign, $character->entity]))
        ->assertDontSee(route('entities.entry.edit', [$campaign, $character->entity]))
        ->assertDontSee(__('entities/story.empty.read_only'));
});

it('shows the read-only empty state for a player without edit or post permissions', function () {
    $this->asUser()->withCampaign();
    $campaign = Campaign::findOrFail(1);
    $character = Character::factory()->create(['campaign_id' => 1]);
    $character->entity->update(['entry' => null]);

    CampaignPermission::create([
        'campaign_id' => 1,
        'campaign_role_id' => 3,
        'entity_type_id' => config('entities.ids.character'),
        'action' => CampaignPermission::ACTION_READ,
        'access' => true,
    ]);
    $this->asPlayer();

    $this->get(route('entities.show', [$campaign, $character->entity]))
        ->assertOk()
        ->assertSee('entity-empty-state')
        ->assertSee(__('entities/story.empty.read_only'))
        ->assertDontSee(route('entities.entry.edit', [$campaign, $character->entity]))
        ->assertDontSee(route('entities.posts.create', [$campaign, $character->entity]));
});

it('shows the read-only empty state for a guest on a public campaign', function () {
    $this->asUser()->withCampaign(['visibility_id' => CampaignVisibility::public->value]);
    $campaign = Campaign::findOrFail(1);
    $publicRole = $campaign->roles()->where('is_public', true)->firstOrFail();

    $character = Character::factory()->create(['campaign_id' => $campaign->id]);
    $character->entity->update(['entry' => null]);

    CampaignPermission::create([
        'campaign_id' => $campaign->id,
        'campaign_role_id' => $publicRole->id,
        'entity_type_id' => config('entities.ids.character'),
        'action' => CampaignPermission::ACTION_READ,
        'access' => true,
    ]);

    auth()->forgetGuards();
    auth()->shouldUse('web');
    $this->withoutMiddleware(ReplicationSwitcher::class);

    $this->get(route('entities.show', [$campaign, $character->entity]))
        ->assertOk()
        ->assertSee('entity-empty-state')
        ->assertSee(__('entities/story.empty.read_only'))
        ->assertDontSee(route('entities.entry.edit', [$campaign, $character->entity]))
        ->assertDontSee(route('entities.posts.create', [$campaign, $character->entity]));
});

it('does not show the empty state when the entity has an entry or a post', function () {
    $this->asUser()->withCampaign();

    $withEntry = Character::factory()->create(['campaign_id' => 1]);
    $withEntry->entity->update(['entry' => '<p>Some lore.</p>']);

    $this->get(route('entities.show', [1, $withEntry->entity]))
        ->assertOk()
        ->assertDontSee('entity-empty-state')
        ->assertSee('btn-new-post')
        ->assertDontSee('post-anchor-loader');

    $withPost = Character::factory()->create(['campaign_id' => 1]);
    $withPost->entity->update(['entry' => null]);
    Post::factory()->create(['entity_id' => $withPost->entity->id]);

    $this->get(route('entities.show', [1, $withPost->entity]))
        ->assertOk()
        ->assertDontSee('entity-empty-state')
        ->assertSee('btn-new-post')
        ->assertSee('post-anchor-loader');
});

it('does not show the empty state for excluded entity types or characters with pinned panels', function () {
    $this->asUser()->withCampaign();

    $map = Map::factory()->create(['campaign_id' => 1]);
    $map->entity->update(['entry' => null]);

    $this->get(route('entities.show', [1, $map->entity]))
        ->assertOk()
        ->assertDontSee('entity-empty-state');

    $character = Character::factory()->create([
        'campaign_id' => 1,
        'is_appearance_pinned' => true,
    ]);
    $character->entity->update(['entry' => null]);

    $this->get(route('entities.show', [1, $character->entity]))
        ->assertOk()
        ->assertDontSee('entity-empty-state')
        ->assertSee('btn-new-post');
});

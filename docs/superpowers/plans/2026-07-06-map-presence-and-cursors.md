# Real-Time Presence and Cursor Sharing for v4 Map Explorer Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Show which campaign members are currently viewing a v4 map ("who's watching") and where each of them is pointing (live cursor positions), mirroring the existing whiteboard presence implementation as closely as possible.

**Architecture:** A new per-map `PresenceChannel` (`map.{id}`), authorized identically to whiteboard's `whiteboard.{id}` channel. Connection details and a `show_presence` flag ride on the existing v4 map API payload (`ExploreApiService::load()`), mirroring `WhiteboardApiService::interactive()`. A new frontend composable (`useMapPresence.js`) owns the `Echo` connection, presence state, and cursor whisper exchange — built as its own module (not shared with whiteboards, and not inlined into `MapExplorer.vue`) because a later, separate pass is already planned to extend this same channel with marker-sync broadcasts.

**Tech Stack:** Laravel 11 / PHP 8.4, Pest, Laravel Reverb, Laravel Echo (`laravel-echo` v2), Vue 3 (Composition API), Leaflet 1.9.

## Global Constraints

- Channel is keyed by the `Map` model's own id (`map.{id}`), not the entity id — matches whiteboard's `whiteboard.{id}` pattern (keyed by the misc-model's own id, not its owning entity's id).
- Authorization: `$user->can('member', $entity->campaign) && $user->can('view', $entity)` — identical to whiteboard's channel closure.
- `show_presence` is computed from the campaign's *total* member count (`> 1`), not how many are currently connected — a solo campaign never shows the who's-watching UI, but the websocket connection is still established regardless (for a future pass where the same user's second tab needs to receive marker-sync updates).
- Cursor positions are shared in map lat/lng (via Leaflet's own `e.latlng`), never screen pixels, so a cursor renders correctly regardless of the viewer's own zoom/pan.
- Cursor sharing uses presence-channel whispers (`channel.whisper()`/`channel.listenForWhisper()`) — no Laravel backend involvement per cursor movement, no new broadcast Event classes.
- No changes to any whiteboard file. Two real, pre-existing bugs were found in `Whiteboard.vue`/`ApiService` while researching the precedent — a `data.schema` (vs. the actual `scheme` key `ApiService::interactive()` sends) typo that makes `forceTLS` always evaluate `false`, and a `user.link` (vs. the actual `url` key the channel closure returns) typo that breaks the tooltip's profile link — neither is reproduced here; this plan's new code consistently uses `scheme` and `url`.
- No marker CRUD broadcasting and no shared cross-feature composable extracted from whiteboards — both explicitly out of scope per the design spec.
- No automated test coverage exists for Vue/Leaflet component interaction in this app (matching the established pattern for every other v4 map explorer change) — frontend verification is live/manual.

---

### Task 1: Presence channel authorization

**Files:**
- Modify: `routes/channels.php`
- Test: `tests/Feature/Entities/Maps/PresenceChannelTest.php` (new)

**Interfaces:**
- Consumes: `App\Models\Map` (existing, has `entity()` via the shared `MiscModel` base class, and `withInvisible()` via the `Acl` trait — the same two methods `Whiteboard` already uses in its own channel closure), `App\Facades\EntityPermission` (existing).
- Produces: a presence channel named `map.{id}` — consumed by Task 2 (the `channel` value handed to the frontend) and Task 3 (the composable that actually joins it).

- [ ] **Step 1: Write the failing tests**

Create `tests/Feature/Entities/Maps/PresenceChannelTest.php`:

```php
<?php

use App\Models\Map;
use App\Models\User;

it('authorizes a campaign member with view access to join the map presence channel, returning the correct shape', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $response = $this->postJson('/broadcasting/auth', [
        'channel_name' => 'presence-map.' . $map->id,
        'socket_id' => '1234.1234',
    ])->assertStatus(200);

    $channelData = json_decode($response->json('channel_data'), true);
    expect($channelData['id'])->toBe(auth()->id());
    expect($channelData['name'])->toBe(auth()->user()->name);
    expect($channelData['role'])->toBe('edit');
});

it('denies a user who is not a member of the map\'s campaign', function () {
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $outsider = User::factory()->create();
    $this->actingAs($outsider);

    $this->postJson('/broadcasting/auth', [
        'channel_name' => 'presence-map.' . $map->id,
        'socket_id' => '1234.1234',
    ])->assertStatus(403);
});
```

Note: if the actual response shape from `/broadcasting/auth` differs from what's assumed above (e.g. `channel_data` isn't a JSON-encoded string, or the status code for a denied presence-channel join differs), the failure output in the next step will show the real response — adjust the assertions to match what Laravel's broadcasting auth route actually returns, rather than guessing further.

- [ ] **Step 2: Run the tests to verify they fail**

Run: `vendor/bin/sail artisan test --compact --filter=PresenceChannelTest`
Expected: FAIL — no `map.{id}` channel is registered yet, so both requests currently 403 (or error) regardless of membership.

- [ ] **Step 3: Register the channel**

In `routes/channels.php`, change:

```php
<?php

use App\Facades\EntityPermission;
use App\Models\User;
use App\Models\Whiteboard;
use Illuminate\Support\Facades\Broadcast;

// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//    return (int) $user->id === (int) $id;
// });

Broadcast::channel('whiteboard.{id}', function (User $user, $id) {
    $whiteboard = Whiteboard::withInvisible()->findOrFail($id);
    $entity = $whiteboard->entity()->withInvisible()->firstOrFail();

    EntityPermission::campaign($entity->campaign);
    if ($user->can('member', $entity->campaign) && $user->can('view', $entity)) {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'image' => $user->hasAvatar() ? $user->getAvatarUrl() : null,
            'url' => route('users.profile', [$user]),
            'role' => $user->can('update', $entity) ? 'edit' : 'view',
        ];
    }

    return false;
});
```

to:

```php
<?php

use App\Facades\EntityPermission;
use App\Models\Map;
use App\Models\User;
use App\Models\Whiteboard;
use Illuminate\Support\Facades\Broadcast;

// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//    return (int) $user->id === (int) $id;
// });

Broadcast::channel('whiteboard.{id}', function (User $user, $id) {
    $whiteboard = Whiteboard::withInvisible()->findOrFail($id);
    $entity = $whiteboard->entity()->withInvisible()->firstOrFail();

    EntityPermission::campaign($entity->campaign);
    if ($user->can('member', $entity->campaign) && $user->can('view', $entity)) {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'image' => $user->hasAvatar() ? $user->getAvatarUrl() : null,
            'url' => route('users.profile', [$user]),
            'role' => $user->can('update', $entity) ? 'edit' : 'view',
        ];
    }

    return false;
});

Broadcast::channel('map.{id}', function (User $user, $id) {
    $map = Map::withInvisible()->findOrFail($id);
    $entity = $map->entity()->withInvisible()->firstOrFail();

    EntityPermission::campaign($entity->campaign);
    if ($user->can('member', $entity->campaign) && $user->can('view', $entity)) {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'image' => $user->hasAvatar() ? $user->getAvatarUrl() : null,
            'url' => route('users.profile', [$user]),
            'role' => $user->can('update', $entity) ? 'edit' : 'view',
        ];
    }

    return false;
});
```

- [ ] **Step 4: Run the tests to verify they pass**

Run: `vendor/bin/sail artisan test --compact --filter=PresenceChannelTest`
Expected: both passing. If the "authorizes" test still fails after registering the channel, check the actual response body printed in the failure output — it will show exactly what `/broadcasting/auth` returned, which is the ground truth for adjusting the assertions.

- [ ] **Step 5: Commit**

```bash
git add routes/channels.php tests/Feature/Entities/Maps/PresenceChannelTest.php
git commit -m "feat: add a presence channel for the v4 map explorer"
```

---

### Task 2: Expose interactive connection config on the map API

**Files:**
- Modify: `app/Services/Maps/ExploreApiService.php`
- Modify: `app/Http/Controllers/Entity/Maps/ApiController.php`
- Modify: `lang/en/maps/explorer.php`
- Test: `tests/Feature/Entities/Maps/ExploreApiControllerTest.php`

**Interfaces:**
- Consumes: `App\Traits\UserAware` (existing trait, already used the same way by `App\Services\Whiteboards\ApiService`), `App\Facades\CampaignCache` (existing, already used by `CampaignPolicy::member()`), Task 1's `map.{id}` channel name.
- Produces: the v4 map API's response gains a top-level `interactive` key — `null` when Reverb isn't configured or the user can't view the map, otherwise `{key, host, port, scheme, channel, show_presence, user: {id, name}}` — consumed by Task 3's composable. Also gains `i18n.presence.{role_edit,role_view,error_unavailable,error_connecting,error_disconnected}` — consumed by Task 3/4.

- [ ] **Step 1: Write the failing tests**

In `tests/Feature/Entities/Maps/ExploreApiControllerTest.php`, add two new imports — change:

```php
use App\Models\Character;
use App\Models\Map;
use App\Models\MapGroup;
use App\Models\MapLayer;
use App\Models\MapMarker;
```

to:

```php
use App\Models\CampaignUser;
use App\Models\Character;
use App\Models\Map;
use App\Models\MapGroup;
use App\Models\MapLayer;
use App\Models\MapMarker;
use App\Models\User;
```

Then append these tests to the end of the file:

```php
it('exposes interactive websocket config when reverb is configured and the user can view the map', function () {
    config([
        'broadcasting.connections.reverb.key' => 'test-key',
        'broadcasting.connections.reverb.options.host' => 'localhost',
        'broadcasting.connections.reverb.options.port' => 8080,
        'broadcasting.connections.reverb.options.scheme' => 'http',
    ]);
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $response = $this->get(route('entities.map-api', [1, $map->entity]))->assertStatus(200);

    expect($response->json('interactive.key'))->toBe('test-key');
    expect($response->json('interactive.host'))->toBe('localhost');
    expect($response->json('interactive.port'))->toBe(8080);
    expect($response->json('interactive.scheme'))->toBe('http');
    expect($response->json('interactive.channel'))->toBe('map.' . $map->id);
    expect($response->json('interactive.user.id'))->toBe(auth()->id());
    expect($response->json('interactive.user.name'))->toBe(auth()->user()->name);
});

it('omits interactive config when reverb is not configured', function () {
    config(['broadcasting.connections.reverb.key' => null]);
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $response = $this->get(route('entities.map-api', [1, $map->entity]))->assertStatus(200);

    expect($response->json('interactive'))->toBeNull();
});

it('sets show_presence to false for a solo-member campaign', function () {
    config([
        'broadcasting.connections.reverb.key' => 'test-key',
        'broadcasting.connections.reverb.options.host' => 'localhost',
        'broadcasting.connections.reverb.options.port' => 8080,
        'broadcasting.connections.reverb.options.scheme' => 'http',
    ]);
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);

    $response = $this->get(route('entities.map-api', [1, $map->entity]))->assertStatus(200);

    expect($response->json('interactive.show_presence'))->toBeFalse();
});

it('sets show_presence to true for a campaign with more than one member', function () {
    config([
        'broadcasting.connections.reverb.key' => 'test-key',
        'broadcasting.connections.reverb.options.host' => 'localhost',
        'broadcasting.connections.reverb.options.port' => 8080,
        'broadcasting.connections.reverb.options.scheme' => 'http',
    ]);
    $this->asUser()->withCampaign();
    $map = Map::factory()->create(['campaign_id' => 1]);
    $secondUser = User::factory()->create();
    CampaignUser::create(['campaign_id' => 1, 'user_id' => $secondUser->id]);

    $response = $this->get(route('entities.map-api', [1, $map->entity]))->assertStatus(200);

    expect($response->json('interactive.show_presence'))->toBeTrue();
});
```

Also change the existing `assertJsonStructure`'s `i18n` line (currently):

```php
            'i18n' => ['legend_title', 'legend_search', 'ungrouped', 'loading', 'error_load', 'error_delete', 'error_save', 'from_entry', 'linked_entry', 'edit_details', 'center', 'duplicate', 'delete_marker', 'delete_confirm', 'new_pin', 'name_placeholder', 'save', 'details', 'less', 'premium_custom_icon', 'markers_count_one', 'markers_count_other', 'toolbar' => ['rapid', 'pin', 'text', 'area', 'circle', 'path', 'helper' => ['pin', 'text', 'area', 'circle', 'path']], 'header' => ['overview', 'settings', 'edit'], 'settings' => ['title', 'grid', 'zoom_min', 'zoom_max', 'zoom_initial', 'distance_name', 'distance_measure', 'center', 'center_coordinates', 'center_marker', 'pick_on_map', 'picking', 'no_marker', 'save', 'error_save']],
```

to:

```php
            'i18n' => ['legend_title', 'legend_search', 'ungrouped', 'loading', 'error_load', 'error_delete', 'error_save', 'from_entry', 'linked_entry', 'edit_details', 'center', 'duplicate', 'delete_marker', 'delete_confirm', 'new_pin', 'name_placeholder', 'save', 'details', 'less', 'premium_custom_icon', 'markers_count_one', 'markers_count_other', 'toolbar' => ['rapid', 'pin', 'text', 'area', 'circle', 'path', 'helper' => ['pin', 'text', 'area', 'circle', 'path']], 'header' => ['overview', 'settings', 'edit'], 'settings' => ['title', 'grid', 'zoom_min', 'zoom_max', 'zoom_initial', 'distance_name', 'distance_measure', 'center', 'center_coordinates', 'center_marker', 'pick_on_map', 'picking', 'no_marker', 'save', 'error_save'], 'presence' => ['role_edit', 'role_view', 'error_unavailable', 'error_connecting', 'error_disconnected']],
```

- [ ] **Step 2: Run the tests to verify they fail**

Run: `vendor/bin/sail artisan test --compact --filter="exposes interactive websocket config|omits interactive config|show_presence"`
Expected: FAIL — `interactive` doesn't exist on the response yet.

- [ ] **Step 3: Add the translation strings**

In `lang/en/maps/explorer.php`, change the end of the file (currently):

```php
    'settings'  => [
        'title'                 => 'Map settings',
        'grid'                  => 'Grid spacing',
        'zoom_min'              => 'Minimum zoom',
        'zoom_max'              => 'Maximum zoom',
        'zoom_initial'          => 'Initial zoom',
        'distance_name'         => 'Distance unit name',
        'distance_measure'      => 'Distance unit factor',
        'center'                => 'Center',
        'center_coordinates'    => 'Coordinates',
        'center_marker'         => 'Marker',
        'pick_on_map'           => 'Pick center on map',
        'picking'               => 'Click the map to set the center...',
        'no_marker'             => 'None selected',
        'save'                  => 'Save',
        'error_save'            => 'Unable to save these settings.',
    ],
];
```

to:

```php
    'settings'  => [
        'title'                 => 'Map settings',
        'grid'                  => 'Grid spacing',
        'zoom_min'              => 'Minimum zoom',
        'zoom_max'              => 'Maximum zoom',
        'zoom_initial'          => 'Initial zoom',
        'distance_name'         => 'Distance unit name',
        'distance_measure'      => 'Distance unit factor',
        'center'                => 'Center',
        'center_coordinates'    => 'Coordinates',
        'center_marker'         => 'Marker',
        'pick_on_map'           => 'Pick center on map',
        'picking'               => 'Click the map to set the center...',
        'no_marker'             => 'None selected',
        'save'                  => 'Save',
        'error_save'            => 'Unable to save these settings.',
    ],
    'presence'  => [
        'role_edit'             => 'Editor',
        'role_view'             => 'Viewer',
        'error_unavailable'     => 'Unable to connect to the live map service.',
        'error_connecting'      => 'Error connecting to the live map service.',
        'error_disconnected'    => 'Lost connection to the live map service.',
    ],
];
```

- [ ] **Step 4: Wire the translations into `ExploreApiService::translations()`**

In `app/Services/Maps/ExploreApiService.php`, change the end of the `translations()` method's returned array (currently):

```php
            'settings' => [
                'title' => __('maps/explorer.settings.title'),
                'grid' => __('maps/explorer.settings.grid'),
                'zoom_min' => __('maps/explorer.settings.zoom_min'),
                'zoom_max' => __('maps/explorer.settings.zoom_max'),
                'zoom_initial' => __('maps/explorer.settings.zoom_initial'),
                'distance_name' => __('maps/explorer.settings.distance_name'),
                'distance_measure' => __('maps/explorer.settings.distance_measure'),
                'center' => __('maps/explorer.settings.center'),
                'center_coordinates' => __('maps/explorer.settings.center_coordinates'),
                'center_marker' => __('maps/explorer.settings.center_marker'),
                'pick_on_map' => __('maps/explorer.settings.pick_on_map'),
                'picking' => __('maps/explorer.settings.picking'),
                'no_marker' => __('maps/explorer.settings.no_marker'),
                'save' => __('maps/explorer.settings.save'),
                'error_save' => __('maps/explorer.settings.error_save'),
            ],
        ];
    }
```

to:

```php
            'settings' => [
                'title' => __('maps/explorer.settings.title'),
                'grid' => __('maps/explorer.settings.grid'),
                'zoom_min' => __('maps/explorer.settings.zoom_min'),
                'zoom_max' => __('maps/explorer.settings.zoom_max'),
                'zoom_initial' => __('maps/explorer.settings.zoom_initial'),
                'distance_name' => __('maps/explorer.settings.distance_name'),
                'distance_measure' => __('maps/explorer.settings.distance_measure'),
                'center' => __('maps/explorer.settings.center'),
                'center_coordinates' => __('maps/explorer.settings.center_coordinates'),
                'center_marker' => __('maps/explorer.settings.center_marker'),
                'pick_on_map' => __('maps/explorer.settings.pick_on_map'),
                'picking' => __('maps/explorer.settings.picking'),
                'no_marker' => __('maps/explorer.settings.no_marker'),
                'save' => __('maps/explorer.settings.save'),
                'error_save' => __('maps/explorer.settings.error_save'),
            ],
            'presence' => [
                'role_edit' => __('maps/explorer.presence.role_edit'),
                'role_view' => __('maps/explorer.presence.role_view'),
                'error_unavailable' => __('maps/explorer.presence.error_unavailable'),
                'error_connecting' => __('maps/explorer.presence.error_connecting'),
                'error_disconnected' => __('maps/explorer.presence.error_disconnected'),
            ],
        ];
    }
```

- [ ] **Step 5: Add `UserAware` and the `interactive()` method to `ExploreApiService`**

Change:

```php
use App\Enums\Visibility;
use App\Http\Resources\Maps\Explore\GroupResource;
use App\Http\Resources\Maps\Explore\LayerResource;
use App\Http\Resources\Maps\Explore\MapResource;
use App\Http\Resources\Maps\Explore\PinResource;
use App\Models\Map;
use App\Traits\CampaignAware;

class ExploreApiService
{
    use CampaignAware;
```

to:

```php
use App\Enums\Visibility;
use App\Facades\CampaignCache;
use App\Http\Resources\Maps\Explore\GroupResource;
use App\Http\Resources\Maps\Explore\LayerResource;
use App\Http\Resources\Maps\Explore\MapResource;
use App\Http\Resources\Maps\Explore\PinResource;
use App\Models\Map;
use App\Traits\CampaignAware;
use App\Traits\UserAware;

class ExploreApiService
{
    use CampaignAware;
    use UserAware;
```

Change the `load()` method's returned array — add `'interactive'` right after `'i18n'`:

```php
            'visibilities' => $this->visibilityOptions(),
            'default_visibility_id' => $this->campaign->defaultVisibility()->value,
            'i18n' => $this->translations(),
        ];
```

to:

```php
            'visibilities' => $this->visibilityOptions(),
            'default_visibility_id' => $this->campaign->defaultVisibility()->value,
            'i18n' => $this->translations(),
            'interactive' => $this->interactive(),
        ];
```

Add the new method next to `visibilityOptions()`:

```php
    protected function interactive(): ?array
    {
        $key = config('broadcasting.connections.reverb.key');
        if (empty($key) || ! $this->hasUser()) {
            return null;
        }

        if (! $this->user->can('view', $this->map->entity)) {
            return null;
        }

        return [
            'key' => $key,
            'host' => config('broadcasting.connections.reverb.options.host'),
            'port' => config('broadcasting.connections.reverb.options.port'),
            'scheme' => config('broadcasting.connections.reverb.options.scheme'),
            'channel' => 'map.' . $this->map->id,
            'show_presence' => CampaignCache::campaign($this->campaign)->members()->count() > 1,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
            ],
        ];
    }
```

- [ ] **Step 6: Wire the current user into the controller**

In `app/Http/Controllers/Entity/Maps/ApiController.php`, change:

```php
    public function index(Campaign $campaign, Entity $entity)
    {
        $this->campaign($campaign)->authEntityView($entity);

        if (! $entity->isMap()) {
            abort(404);
        }

        return response()->json(
            $this->apiService
                ->campaign($campaign)
                ->map($entity->child)
                ->load()
        );
    }
```

to:

```php
    public function index(Campaign $campaign, Entity $entity)
    {
        $this->campaign($campaign)->authEntityView($entity);

        if (! $entity->isMap()) {
            abort(404);
        }

        if (auth()->check()) {
            $this->apiService->user(auth()->user());
        }

        return response()->json(
            $this->apiService
                ->campaign($campaign)
                ->map($entity->child)
                ->load()
        );
    }
```

(Matches `App\Http\Controllers\Whiteboards\ApiController::index()`'s identical `if (auth()->check()) { $this->apiService->user(auth()->user()); }` line exactly — guests never get `->user()` set, so `interactive()`'s `hasUser()` check correctly returns `null` for them.)

- [ ] **Step 7: Run the tests to verify they pass**

Run: `vendor/bin/sail artisan test --compact --filter="exposes interactive websocket config|omits interactive config|show_presence|returns the full explore payload"`
Expected: all passing.

- [ ] **Step 8: Commit**

```bash
git add app/Services/Maps/ExploreApiService.php app/Http/Controllers/Entity/Maps/ApiController.php lang/en/maps/explorer.php tests/Feature/Entities/Maps/ExploreApiControllerTest.php
git commit -m "feat: expose interactive websocket config on the v4 map API"
```

---

### Task 3: `useMapPresence` composable

**Files:**
- Create: `resources/js/composables/useMapPresence.js`

**Interfaces:**
- Consumes: `interactive`/`i18n.presence` shape from Task 2 (via getter functions, not raw values — see below).
- Produces: `useMapPresence(getInteractive, getI18n)` where both arguments are zero-arg functions (not plain values) returning the current `interactive` object (or `null`/`undefined`) and the current `i18n.presence` object respectively. Returns `{ activeUsers: Ref<Array>, remoteCursors: Ref<Object>, error: Ref<string|null>, sendCursor: (lat: number, lng: number) => void }` — consumed by Task 4 (`activeUsers`, `error`) and Task 5 (`remoteCursors`, `sendCursor`).

**Why getter functions, not raw values:** `MapExplorer.vue`'s map data loads asynchronously (an `axios.get` inside `onMounted`), so `interactive` doesn't exist yet at the moment this composable must be called. Vue requires lifecycle hooks like `onBeforeUnmount` to be registered synchronously during a component's initial setup — calling this composable only *after* the async fetch resolves would happen too late for that registration to work. Passing getter functions lets the composable be called synchronously at the top of `<script setup>` (satisfying Vue's lifecycle-hook timing rule) while still reacting correctly once the real `interactive` value arrives, via an internal `watch(getInteractive, ..., { immediate: true })`.

- [ ] **Step 1: Create the composable**

Create `resources/js/composables/useMapPresence.js`:

```js
import { onBeforeUnmount, ref, watch } from 'vue'
import Echo from 'laravel-echo'
import Pusher from 'pusher-js'

// laravel-echo's reverb broadcaster routes through the same Pusher-protocol
// connector as the 'pusher' broadcaster, which requires a Pusher client to be
// globally available (or passed via options.client) — it is never bundled
// automatically, so it must be set here explicitly.
window.Pusher = Pusher

const CURSOR_EVENT = 'cursor'

function colourForUser(userId) {
    const hue = (Number(userId) * 137.508) % 360

    return `hsl(${hue}, 70%, 50%)`
}

export function useMapPresence(getInteractive, getI18n) {
    const activeUsers = ref([])
    const remoteCursors = ref({})
    const error = ref(null)

    let echo = null
    let channel = null
    let connectedChannelName = null

    function connect(interactive) {
        if (!interactive || channel) {
            return
        }

        const i18n = getI18n() || {}

        echo = new Echo({
            broadcaster: 'reverb',
            key: interactive.key,
            wsHost: interactive.host,
            wsPort: interactive.port,
            wssPort: interactive.port,
            forceTLS: interactive.scheme === 'https',
            enabledTransports: ['ws', 'wss'],
        })

        echo.connector.pusher.connection.bind('unavailable', () => {
            error.value = i18n.error_unavailable
        })

        echo.connector.pusher.connection.bind('error', () => {
            error.value = i18n.error_connecting
        })

        channel = echo.join(interactive.channel)
        connectedChannelName = interactive.channel

        channel.here((users) => {
            activeUsers.value = users
        })

        channel.joining((user) => {
            activeUsers.value = [...activeUsers.value, user]
        })

        channel.leaving((user) => {
            activeUsers.value = activeUsers.value.filter((u) => u.id !== user.id)

            const cursors = { ...remoteCursors.value }
            delete cursors[user.id]
            remoteCursors.value = cursors
        })

        channel.listenForWhisper(CURSOR_EVENT, (payload) => {
            remoteCursors.value = {
                ...remoteCursors.value,
                [payload.userId]: {
                    lat: payload.lat,
                    lng: payload.lng,
                    name: payload.name,
                    colour: colourForUser(payload.userId),
                },
            }
        })

        channel.error(() => {
            error.value = i18n.error_disconnected
        })
    }

    watch(getInteractive, (interactive) => connect(interactive), { immediate: true })

    function sendCursor(lat, lng) {
        const interactive = getInteractive()
        if (!channel || !interactive) {
            return
        }

        channel.whisper(CURSOR_EVENT, {
            userId: interactive.user.id,
            name: interactive.user.name,
            lat,
            lng,
        })
    }

    onBeforeUnmount(() => {
        if (echo && connectedChannelName) {
            echo.leave(connectedChannelName)
        }
    })

    return { activeUsers, remoteCursors, error, sendCursor }
}
```

(Added after the user's own first live test, since the final whole-branch review's zero-live-testing gap turned out to hide a real bug: without this `Pusher`/`window.Pusher` setup, the browser console showed `Error: Pusher client not found. Should be globally available or passed via options.client` the moment `useMapPresence` tried to connect — this is the one thing code review couldn't catch, since it's a missing runtime dependency, not a logic error. `pusher-js` was already a project dependency (`package.json`), just never wired into anything that actually ran; no new dependency was needed, only this import + global assignment.)

- [ ] **Step 2: Verify the build compiles**

Run: `vendor/bin/sail yarn run build`
Expected: build succeeds with no errors (this file isn't imported by anything yet — Task 4 wires it up — so this only checks the file's own syntax).

- [ ] **Step 3: Commit**

```bash
git add resources/js/composables/useMapPresence.js
git commit -m "feat: add a useMapPresence composable for the v4 map explorer"
```

---

### Task 4: Who's-watching avatar list

**Files:**
- Modify: `resources/js/components/maps/MapExplorer.vue`
- Modify: `resources/js/maps/explore.js`

**Found during the user's own live testing, after the Pusher-client fix above:** this task is the first thing in the v4 map explorer's Vue app to ever use `v-tippy` (both the avatar tooltips and the connection-error icon added later in this same task). The `v-tippy` directive comes from the `vue-tippy` plugin, which every other Vue entry point in this codebase registers explicitly (e.g. `resources/js/entities/explore.js`: `app.use(VueTippy, { theme: 'kanka' })`) — but `resources/js/maps/explore.js` (the v4 map explorer's own entry point) never did, since nothing needed it before. The browser showed `[Vue warn]: Failed to resolve directive: tippy`. Fixed by adding the same registration `entities/explore.js` already uses. Change:

```js
import 'leaflet/dist/leaflet.css'
import 'leaflet.markercluster/dist/MarkerCluster.css'
import 'leaflet.markercluster/dist/MarkerCluster.Default.css'
import { createApp } from 'vue'
import MapExplorer from '../components/maps/MapExplorer.vue'

const app = createApp({})
app.component('map-explorer', MapExplorer)
app.mount('#map-explorer')
```

to:

```js
import 'leaflet/dist/leaflet.css'
import 'leaflet.markercluster/dist/MarkerCluster.css'
import 'leaflet.markercluster/dist/MarkerCluster.Default.css'
import { createApp } from 'vue'
import VueTippy from 'vue-tippy'
import MapExplorer from '../components/maps/MapExplorer.vue'

const app = createApp({})
app.use(VueTippy, { theme: 'kanka' })
app.component('map-explorer', MapExplorer)
app.mount('#map-explorer')
```

**Interfaces:**
- Consumes: `useMapPresence` (Task 3), `data.interactive`/`data.i18n.presence` (Task 2). Note: `interactive` is a **top-level sibling key** of `map` in `ExploreApiService::load()`'s response (`app/Services/Maps/ExploreApiService.php:49`), not nested inside `map` — it must be read as `data.value.interactive`, not `data.value.map.interactive`. This is called out explicitly because it's easy to guess wrong by analogy with `map.settings`/`map.center`, which genuinely do live inside `map`.
- Produces: nothing new for later tasks — `activeUsers`/`error` are consumed only within this same file's template.

- [ ] **Step 1: Import and call the composable**

In `resources/js/components/maps/MapExplorer.vue`, change:

```js
import { ref, computed, onMounted, onBeforeUnmount, nextTick } from "vue";
import tippy from "tippy.js";
import { centroid } from "../../maps/polygon.js";
import DetailPanel from "./DetailPanel.vue";
import LeafletCanvas from "./LeafletCanvas.vue";
import LegendPanel from "./LegendPanel.vue";
import MarkerPanel from "./MarkerPanel.vue";
import SettingsPanel from "./SettingsPanel.vue";
import Toolbar from "./Toolbar.vue";
```

to:

```js
import { ref, computed, onMounted, onBeforeUnmount, nextTick } from "vue";
import tippy from "tippy.js";
import { useMapPresence } from "../../composables/useMapPresence.js";
import { centroid } from "../../maps/polygon.js";
import DetailPanel from "./DetailPanel.vue";
import LeafletCanvas from "./LeafletCanvas.vue";
import LegendPanel from "./LegendPanel.vue";
import MarkerPanel from "./MarkerPanel.vue";
import SettingsPanel from "./SettingsPanel.vue";
import Toolbar from "./Toolbar.vue";
```

Add the composable call next to the other top-level `const`/`ref` declarations — change:

```js
const settingsOpen = ref(false);
const pendingCenter = ref(null);
const previewCenter = ref(null);
const mapMenuBtnRef = ref(null);
const mapMenuRef = ref(null);
let mapMenuInstance = null;
```

to:

```js
const settingsOpen = ref(false);
const pendingCenter = ref(null);
const previewCenter = ref(null);
const mapMenuBtnRef = ref(null);
const mapMenuRef = ref(null);
let mapMenuInstance = null;

const {
    activeUsers,
    remoteCursors,
    error: presenceError,
    sendCursor,
} = useMapPresence(
    () => data.value.interactive,
    () => data.value.i18n?.presence,
);
```

(`interactive` is a top-level key alongside `map`/`i18n` in the API response, NOT nested inside `map` — `data.value.interactive`, not `data.value.map.interactive`.)

- [ ] **Step 2: Add the avatar list to the header**

Change:

```html
                <p class="text-sm text-neutral-content">{{ markersCountText }}</p>
            </div>
        </div>

        <LegendPanel
```

to:

```html
                <p class="text-sm text-neutral-content">{{ markersCountText }}</p>
            </div>

            <div class="flex gap-1 overflow-hidden" v-if="data.interactive?.show_presence">
                <span
                    v-for="user in activeUsers"
                    :key="user.id"
                    :aria-label="user.name"
                    class="bg-base-200 text-neutral-content rounded-full h-8 w-8 overflow-hidden flex items-center justify-center cursor-pointer flex-none"
                    v-tippy="presenceTooltip(user)"
                >
                    <img :src="user.image" v-if="user.image" class="w-8 h-8" />
                    <span v-else>{{ user.name.substring(0, 2).toUpperCase() }}</span>
                </span>
            </div>
        </div>

        <LegendPanel
```

Add the tooltip-building function next to `markersCountText` — change:

```js
const markersCountText = computed(() => {
    const count = data.value.pins.length;
    const template = count === 1 ? data.value.i18n.markers_count_one : data.value.i18n.markers_count_other;

    return template.replace(':count', count);
});
```

to:

```js
const markersCountText = computed(() => {
    const count = data.value.pins.length;
    const template = count === 1 ? data.value.i18n.markers_count_one : data.value.i18n.markers_count_other;

    return template.replace(':count', count);
});

function presenceTooltip(user) {
    const i18n = data.value.i18n.presence;
    const role = user.role === "edit" ? i18n.role_edit : i18n.role_view;

    return (
        '<div class="flex flex-col gap-1">' +
        '<a class="text-link text-lg" href="' + user.url + '">' + user.name + "</a>" +
        '<span class="text-neutral-content text-xs">' + role + "</span></div>"
    );
}
```

(Deliberately uses `user.url`, matching what the channel closure in `routes/channels.php` actually returns — not `user.link`, the typo present in whiteboard's own `getUserTooltip()`.)

- [ ] **Step 3: Surface connection errors instead of failing silently**

Added after implementation, from the final whole-branch review: `useMapPresence`'s `error` ref (renamed `presenceError` at the destructure site) is set on connection failure, but nothing ever displayed it — a broken websocket connection currently means no avatars, no cursors, and no visible indication anything went wrong. Add a small, unobtrusive indicator next to the avatar list. Change:

```html
            <div class="flex gap-1 overflow-hidden" v-if="data.interactive?.show_presence">
                <span
                    v-for="user in activeUsers"
                    :key="user.id"
                    :aria-label="user.name"
                    class="bg-base-200 text-neutral-content rounded-full h-8 w-8 overflow-hidden flex items-center justify-center cursor-pointer flex-none"
                    v-tippy="presenceTooltip(user)"
                >
                    <img :src="user.image" v-if="user.image" class="w-8 h-8" />
                    <span v-else>{{ user.name.substring(0, 2).toUpperCase() }}</span>
                </span>
            </div>
        </div>
```

to:

```html
            <div class="flex gap-1 overflow-hidden" v-if="data.interactive?.show_presence">
                <span
                    v-for="user in activeUsers"
                    :key="user.id"
                    :aria-label="user.name"
                    class="bg-base-200 text-neutral-content rounded-full h-8 w-8 overflow-hidden flex items-center justify-center cursor-pointer flex-none"
                    v-tippy="presenceTooltip(user)"
                >
                    <img :src="user.image" v-if="user.image" class="w-8 h-8" />
                    <span v-else>{{ user.name.substring(0, 2).toUpperCase() }}</span>
                </span>
            </div>

            <i
                v-if="presenceError"
                class="fa-regular fa-triangle-exclamation text-warning flex-none"
                aria-hidden="true"
                v-tippy="presenceError"
            />
        </div>
```

This renders regardless of `show_presence` (a solo-campaign user in a second tab, or a guest, should still learn if their websocket connection failed, even though they'd never see the avatar list). Uses the existing `v-tippy` pattern already established for the avatar tooltips right next to it — a warning icon, not a permanent text banner, to stay unobtrusive.

- [ ] **Step 4: Verify the build compiles**

Run: `vendor/bin/sail yarn run build`
Expected: build succeeds with no errors.

- [ ] **Step 5: Manually verify**

Using two authenticated sessions (e.g. two browser profiles, or one regular + one incognito window) as two different members of the same multi-member campaign: open the same map in both, confirm each session's avatar appears in the other's who's-watching list within a few seconds, confirm the tooltip shows the correct name and role (editor/viewer, matching each user's actual permission), and confirm closing one session removes its avatar from the other's list promptly. Then confirm the list never appears at all in a solo-member campaign, even across two tabs of the same account. Also confirm the new warning icon appears (with `presenceError`'s message in its tooltip) if the websocket connection genuinely fails — e.g. temporarily pointing the Reverb config at an unreachable host — and stays absent otherwise.

- [ ] **Step 6: Commit**

```bash
git add resources/js/components/maps/MapExplorer.vue
git commit -m "feat: show which campaign members are viewing the v4 map"
```

---

### Task 5: Cursor sharing

**Files:**
- Modify: `resources/js/components/maps/LeafletCanvas.vue`
- Modify: `resources/js/components/maps/MapExplorer.vue`

**Interfaces:**
- Consumes: `sendCursor`/`remoteCursors` from Task 3/4's composable call in `MapExplorer.vue`.
- Produces: a new `cursor-move` emit from `LeafletCanvas.vue` (`{lat, lng}`), handled by `MapExplorer.vue` calling `sendCursor(lat, lng)`. Nothing later in this plan consumes this further.

- [ ] **Step 1: Add the `remoteCursors` prop and `cursor-move` emit to `LeafletCanvas.vue`**

Change:

```js
const props = defineProps({
    map: { type: Object, required: true },
    layers: { type: Array, default: () => [] },
    pins: { type: Array, default: () => [] },
    centerPin: { type: Object, default: null },
    centerNonce: { type: Number, default: 0 },
    activeMode: { type: String, default: null },
    draftPin: { type: Object, default: null },
    previewCenter: { type: Array, default: null },
    canEdit: { type: Boolean, default: false },
    defaultPolygonStyle: {
        type: Object,
        default: () => ({ colour: '#93c5fd', opacity: 50, stroke: '#93c5fd', 'stroke-width': 1 }),
    },
})

const emit = defineEmits(['pin-click', 'map-click', 'polygon-change', 'polygon-finish', 'circle-change', 'circle-finish', 'path-change', 'path-finish', 'measure-change', 'pin-moved'])
```

to:

```js
const props = defineProps({
    map: { type: Object, required: true },
    layers: { type: Array, default: () => [] },
    pins: { type: Array, default: () => [] },
    centerPin: { type: Object, default: null },
    centerNonce: { type: Number, default: 0 },
    activeMode: { type: String, default: null },
    draftPin: { type: Object, default: null },
    previewCenter: { type: Array, default: null },
    canEdit: { type: Boolean, default: false },
    remoteCursors: { type: Object, default: () => ({}) },
    defaultPolygonStyle: {
        type: Object,
        default: () => ({ colour: '#93c5fd', opacity: 50, stroke: '#93c5fd', 'stroke-width': 1 }),
    },
})

const emit = defineEmits(['pin-click', 'map-click', 'polygon-change', 'polygon-finish', 'circle-change', 'circle-finish', 'path-change', 'path-finish', 'measure-change', 'pin-moved', 'cursor-move'])
```

- [ ] **Step 2: Add a cursor-rendering layer**

Add this next to `buildGrid()`/`buildRuler()` (any of the `build*` functions is a fine location — place it near `buildGrid()`):

```js
let cursorLayer = null

function buildCursors() {
    if (cursorLayer) {
        leafletMap.removeLayer(cursorLayer)
    }

    cursorLayer = L.layerGroup()

    Object.values(props.remoteCursors).forEach((cursor) => {
        L.circleMarker([cursor.lat, cursor.lng], {
            radius: 6,
            color: cursor.colour,
            fillColor: cursor.colour,
            fillOpacity: 0.8,
            interactive: false,
        }).addTo(cursorLayer)
    })

    cursorLayer.addTo(leafletMap)
}
```

Add a watcher next to the existing `watch(() => props.map.settings?.grid, ...)` block:

```js
watch(() => props.remoteCursors, () => {
    if (leafletMap) {
        buildCursors()
    }
})
```

- [ ] **Step 3: Emit throttled local cursor position on `mousemove`**

Change the end of `onMounted` from:

```js
    buildBaseLayer()
    buildLayers()
    buildPins()
    buildDraftMarker()
    buildGrid()
    buildRuler()

    document.addEventListener('keydown', handlePolygonKeydown)
})
```

to:

```js
    buildBaseLayer()
    buildLayers()
    buildPins()
    buildDraftMarker()
    buildGrid()
    buildRuler()
    buildCursors()

    let lastCursorSentAt = 0
    leafletMap.on('mousemove', (e) => {
        const now = Date.now()
        if (now - lastCursorSentAt < 100) {
            return
        }
        lastCursorSentAt = now
        emit('cursor-move', { lat: e.latlng.lat, lng: e.latlng.lng })
    })

    document.addEventListener('keydown', handlePolygonKeydown)
})
```

(Throttled to roughly 10 times per second — frequent enough to feel live, infrequent enough not to flood the channel.)

- [ ] **Step 4: Wire `MapExplorer.vue`**

Change:

```html
        <LeafletCanvas
            :map="data.map"
            :layers="data.layers"
            :pins="data.pins"
            :center-pin="selectedPin"
            :center-nonce="centerNonce"
            :active-mode="activeMode"
            :draft-pin="draftPin"
            :preview-center="previewCenter"
            :can-edit="canEdit"
            :default-polygon-style="defaultPolygonStyle()"
            @pin-click="selectPin"
            @map-click="handleMapClick"
            @polygon-change="handlePolygonChange"
            @polygon-finish="handlePolygonFinish"
            @circle-change="handleCircleChange"
            @circle-finish="handleCircleFinish"
            @path-change="handlePathChange"
            @path-finish="handlePathFinish"
            @measure-change="handleMeasureChange"
            @pin-moved="handlePinMoved"
        />
```

to:

```html
        <LeafletCanvas
            :map="data.map"
            :layers="data.layers"
            :pins="data.pins"
            :center-pin="selectedPin"
            :center-nonce="centerNonce"
            :active-mode="activeMode"
            :draft-pin="draftPin"
            :preview-center="previewCenter"
            :can-edit="canEdit"
            :remote-cursors="remoteCursors"
            :default-polygon-style="defaultPolygonStyle()"
            @pin-click="selectPin"
            @map-click="handleMapClick"
            @polygon-change="handlePolygonChange"
            @polygon-finish="handlePolygonFinish"
            @circle-change="handleCircleChange"
            @circle-finish="handleCircleFinish"
            @path-change="handlePathChange"
            @path-finish="handlePathFinish"
            @measure-change="handleMeasureChange"
            @pin-moved="handlePinMoved"
            @cursor-move="handleCursorMove"
        />
```

Add the handler next to `handlePinMoved` — change:

```js
function handlePinMoved({ id, latitude, longitude }) {
    data.value.pins = data.value.pins.map((pin) =>
        pin.id === id ? { ...pin, latitude, longitude } : pin
    );
}
```

to:

```js
function handlePinMoved({ id, latitude, longitude }) {
    data.value.pins = data.value.pins.map((pin) =>
        pin.id === id ? { ...pin, latitude, longitude } : pin
    );
}

function handleCursorMove({ lat, lng }) {
    sendCursor(lat, lng);
}
```

- [ ] **Step 5: Verify the build compiles**

Run: `vendor/bin/sail yarn run build`
Expected: build succeeds with no errors.

- [ ] **Step 6: Manually verify**

Using the same two-session setup as Task 4's verification: move the mouse over the map in one session, confirm a small coloured dot appears and live-updates in the other session's map at the corresponding spot. Confirm the dot's position stays correct even if the two sessions have different zoom/pan (since positions are shared in map coordinates, not screen pixels). Confirm the dot disappears promptly when that session closes/leaves. Confirm a solo-member campaign still gets a working cursor exchange between two tabs of the same account (the websocket connection is unconditional, independent of `show_presence`).

- [ ] **Step 7: Commit**

```bash
git add resources/js/components/maps/LeafletCanvas.vue resources/js/components/maps/MapExplorer.vue
git commit -m "feat: share live cursor positions on the v4 map explorer"
```

---

### Task 6: End-to-end verification

**Files:** none (verification only).

- [ ] **Step 1: Run the full backend test suite for maps**

```bash
vendor/bin/sail artisan test --compact --filter=Maps
```

Expected: all passing.

- [ ] **Step 2: Run Pint**

```bash
vendor/bin/sail bin pint --dirty --format agent
```

Expected: no remaining style issues.

- [ ] **Step 3: Full manual walkthrough**

Repeat Task 4 and Task 5's manual checks together in one consolidated pass, using two real authenticated sessions in a multi-member campaign, plus:
- Confirm a guest viewer (no login) sees no errors and no presence/cursor UI at all — the feature degrades silently.
- If possible, temporarily unset the Reverb config (or point it at a host with nothing listening) and confirm the map explorer still loads and functions normally otherwise — no broken UI, no unhandled JS errors, just no presence/cursor features (the `error` state from `useMapPresence` surfaces the connection failure, matching whiteboard's own error-handling for the same failure modes — check the browser console/network tab for the expected `unavailable`/`error` handling paths).
- Confirm dragging a draggable marker (existing feature) and picking a new map center (existing feature) both continue to work correctly alongside the new mousemove listener — no interference between them.

- [ ] **Step 4: Fix forward if any check fails**

If a step above fails, return to the relevant task, fix it, re-run that task's own verification, then re-run this task's steps from the top.

- [ ] **Step 5: Final commit (if any fixes were made in Step 3)**

```bash
git add -A
git commit -m "fix: address issues found in map presence/cursor end-to-end verification"
```

# Map Metadata Change Broadcasting Design

## Goal

When a map's name, grid, unit-measurement config (distance measure/name), legacy pin layout mode, or min/max zoom changes, push that update over the existing `map.{id}` presence channel so everyone with that map open in the v4 (Vue/Leaflet) explorer sees the change live, without reloading. This must fire regardless of which of the two existing save paths made the change: the Vue `SettingsPanel` (`Entity\Maps\SettingsController`) or the classic Blade entity edit form (`Crud\MapController` → `CrudController::crudUpdate()`).

## Out of Scope

- Center (`center_x`/`center_y`/`center_marker_id`) and `initial_zoom` changes are explicitly excluded from this broadcast (confirmed with user) — only the fields named above trigger it.
- No new presence-channel authorization work — `routes/channels.php`'s existing `Broadcast::channel('map.{id}', ...)` (added for [[2026-07-06-map-presence-and-cursors-design]]) is reused as-is.
- No toast/notification UI for the change — the update applies silently to reactive state, the same way `handleSettingsSaved` already applies the saving user's own response today.
- No `->toOthers()` socket exclusion. The map explorer's `useMapPresence.js` opens its own ad-hoc `Echo` connection (not `window.Echo`), so a `X-Socket-Id` header keyed to that connection is never sent with the triggering axios request — `toOthers()` would have nothing correct to exclude. The saving user's own tab re-receiving and re-applying an identical `MapResource` payload is harmless (it's the same merge `handleSettingsSaved` already performs).
- No broadcasting on map creation — only `updated`, not `created`, is observed.

## Background

- `useMapPresence.js` already joins a presence channel per map (`map.{id}`) for who's-watching + cursor whispering ([[2026-07-06-map-presence-and-cursors-design]]), but no backend Event currently broadcasts onto that channel — it's presence-lifecycle and whisper-only so far.
- The whiteboard feature has direct precedent for broadcasting model changes onto its own presence channel: `App\Events\Whiteboards\Updated` implements `ShouldBroadcastNow`, targets `new PresenceChannel("whiteboard.{$this->whiteboard->id}")`, defines a short `broadcastAs()` name, and shapes its payload explicitly via `broadcastWith()` using an API Resource. This design copies that pattern for maps.
- Two save paths both need to trigger this, and neither is a shared code path:
  - `Entity\Maps\SettingsController::update()` — the Vue `SettingsPanel`'s endpoint. Handles `grid`, `min_zoom`, `max_zoom`, `initial_zoom`, `center_*`, and `config.{distance_measure,distance_name,legacy_pins}`. Never touches `name`.
  - `Crud\MapController` (via `CrudController::crudUpdate()`) — the classic entity edit form. Handles `name`, `center_*`, `min_zoom`/`max_zoom`/`initial_zoom` (via `StoreMap`), but not `grid` or the `config` sub-fields.
  - Rather than duplicating a broadcast call in both controllers (and inevitably missing a third path later, e.g. an API v1 map update), this hooks into `App\Observers\MapObserver`, which already exists and is registered for the `Map` model in `AppServiceProvider`.
- `Map`'s `config` column is a single JSON/array-cast blob currently holding exactly `distance_measure`, `distance_name`, and `legacy_pins` — no unrelated keys live there today. Watching the whole `config` attribute for changes (rather than diffing individual sub-keys) covers "unit measurement data" and "legacy layout mode" with one check.
- `App\Http\Resources\Maps\Explore\MapResource` already produces the exact payload shape the frontend expects for `data.map` (it's what `SettingsController::update()` returns today, and what `MapExplorer.vue`'s `handleSettingsSaved` assigns wholesale to `data.value.map`). Reusing it keeps the broadcast payload identical to a normal settings-save response.

## Architecture

**1. New event** — `App\Events\Maps\Updated`, implementing `ShouldBroadcastNow` (mirrors `App\Events\Whiteboards\Updated`):
- Constructor takes the `Map $map`, calls `$this->broadcastVia('reverb')`.
- `broadcastOn()`: `[new PresenceChannel("map.{$this->map->id}")]`.
- `broadcastAs()`: `'MapUpdated'`.
- `broadcastWith()`: `['map' => new MapResource($this->map)->campaign($this->map->campaign)]` — same resource/shape the two save-path controllers already return synchronously to their own caller.

**2. `MapObserver::updated(Map $map)`** (new method on the existing observer) — the single trigger point for both save paths:
```php
public function updated(Map $map): void
{
    if (! $map->wasChanged(['name', 'grid', 'min_zoom', 'max_zoom', 'config'])) {
        return;
    }

    broadcast(new \App\Events\Maps\Updated($map));
}
```
This fires once per `Model::save()`/`update()` call where a watched attribute actually changed value, regardless of whether it came from `SettingsController`, `CrudController::crudUpdate()`, or any future caller. It does not fire for the incidental second save `Crud\MapController::afterModelSave()` performs to recalculate `height`/`width`, since those aren't in the watched list.

**3. Frontend — `useMapPresence.js`** gains a third parameter, an `onMapUpdated(map)` callback. After joining the channel (existing `echo.join(interactive.channel)` call), it adds:
```js
channel.listen('.MapUpdated', (payload) => onMapUpdated(payload.map))
```
(The leading `.` is required because `broadcastAs()` returns a bare name with no model-event namespace prefix — same convention as listening for whispered/custom events elsewhere in this codebase.)

**4. `MapExplorer.vue`** passes a new callback into `useMapPresence`:
```js
function handleRemoteMapUpdate(map) {
    data.value.map = map;
}
```
This is the same assignment `handleSettingsSaved` already does — no new merge logic, just a second caller of the same effect.

## Testing

Backend: Pest feature/unit tests on `MapObserver`:
- Changing `name`, `grid`, `min_zoom`, `max_zoom`, or any `config` sub-key (`distance_measure`, `distance_name`, `legacy_pins`) individually each results in `App\Events\Maps\Updated` being broadcast (assert via `Event::fake()` / `Broadcast::assertDispatched` or equivalent), carrying a `MapResource`-shaped payload for the correct map.
- Changing only unrelated attributes (e.g. `height`/`width`, as `Crud\MapController::afterModelSave()` does) does not dispatch the event.
- Both existing save paths are covered end-to-end: a `PATCH` to `SettingsController::update()`'s route changing `grid`/`legacy_pins`/etc. dispatches the event; a `PUT`/`PATCH` to the entity edit form changing `name` also dispatches it.

Frontend: no automated test coverage exists for Vue/Leaflet component interaction in this app (matching the established pattern for other v4 map explorer real-time work). Manual verification: with two authenticated sessions viewing the same map, saving a change to name (entity form), grid/zoom/legacy-pins/unit-measurement (SettingsPanel) in one session should update the other session's map immediately without a reload; changing only the map center should *not* trigger any visible update in the other session.

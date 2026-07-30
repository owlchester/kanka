# Legacy Pin Style Toggle Design

## Goal

Give each map a per-map opt-out from the new compact icon-based pin rendering (introduced in the uncommitted `LeafletCanvas.vue` restyle) back to the old colour-teardrop look, via a checkbox in that map's Settings panel. Defaults to off (`false`) so every map — existing and new — renders with the new style unless an editor explicitly opts back into the legacy look.

## Out of Scope

- No per-campaign or global/user-level default — this is strictly a per-map setting, matching how `grid`/zoom/distance settings already work (decided during brainstorming).
- No backfill/migration of existing maps — storing the flag as an optional key in the existing `config` JSON blob means any map without it reads as `false` (new style) automatically.
- No realtime broadcast of the setting change to other concurrent viewers of the map — only the editor who saves the Settings panel sees the change applied live (their local `data.map` is already replaced wholesale on save); other viewers pick it up on their next load, same as every other map setting today.
- No changes to per-marker data (`MapMarker`/`PinResource`) — the toggle is map-level only; individual markers don't carry a style flag.
- No change to which icon variants exist — this only switches which of the two already-built `LeafletCanvas.vue` renderers (legacy teardrop vs. new bare-icon, from the uncommitted restyle) is used for a given map.

## Background

`Map::config` (`app/Models/Map.php:88,92`) is an existing `array`-cast, fillable JSON column already used to hold settings that don't need their own schema column — today just `distance_measure`/`distance_name` (`App\Http\Controllers\Entity\Maps\SettingsController::update`, `app/Http/Controllers/Entity/Maps/SettingsController.php:34-42`, which merges those two keys into `$config` before `$map->update($data)`, keeping them out of the FormRequest's direct `$data` pass-through).

`UpdateMapSettings` (`app/Http/Requests/UpdateMapSettings.php`) validates the Settings-panel payload; `MapResource` (`app/Http/Resources/Maps/Explore/MapResource.php:56-68`) assembles the `settings` object the Vue explorer reads, including the two `config`-backed fields (`:63-64`).

`SettingsPanel.vue` (`resources/js/components/maps/SettingsPanel.vue`) owns the per-map settings form: a `reactive` `form` object is populated from `props.map.settings` when the panel opens (`:135-155`), and PATCHed to `props.map.settings_url` on save (`:186-209`). `MapExplorer.vue`'s `handleSettingsSaved(map)` (`resources/js/components/maps/MapExplorer.vue:284-286`) replaces `data.value.map` wholesale with the response, which is how existing settings (grid, zoom, etc.) already apply live without a page reload — no new plumbing needed for that.

`LeafletCanvas.vue`'s `pinIcon()` (currently uncommitted on this branch) was just rewritten to drop the old colour-teardrop `marker-pin` div/CSS in favour of bare, colour-filled FontAwesome glyphs with a base-content stroke. The old teardrop implementation (a `marker-pin` div background-coloured to `pin.colour`, with the icon layered on top, rotated -45deg with a counter-rotated avatar photo trick, default `pin_size` 40px, dashed-white draft outline) needs to be restored as an alternate code path rather than lost, since some users want it back.

`lang/en/maps/explorer.php`'s `settings` array (`:69-85`) and `App\Services\Maps\ExploreApiService`'s matching `settings` i18n block (`:161-177`) are the existing pattern for adding a new labelled Settings-panel field.

## Architecture

**1. Storage & validation.** Add `legacy_pins` as an optional boolean key inside `Map::config`, following the exact pattern `distance_measure`/`distance_name` already use:
- `UpdateMapSettings::rules()`: add `'legacy_pins' => 'sometimes|boolean'`.
- `SettingsController::update()`: alongside the existing `distance_measure`/`distance_name` merge into `$config`, add `if (array_key_exists('legacy_pins', $data)) { $config['legacy_pins'] = $data['legacy_pins']; } unset($data['legacy_pins']);`.
- `MapResource`: add `'legacy_pins' => (bool) ($map->config['legacy_pins'] ?? false)` to the `settings` array.

**2. i18n.** Add two keys under `lang/en/maps/explorer.php`'s `settings` array: `legacy_pins` ("Use legacy pin style") and `legacy_pins_help` ("Show pins with the older colour-teardrop look instead of the newer compact icons. Other people viewing this map will see the change after they reload the page."). Wire both through `ExploreApiService`'s `settings` i18n block the same way every other key there is wired.

**3. `SettingsPanel.vue`.** Add `form.legacy_pins` (boolean) to the reactive form, initialized from `settings.legacy_pins` in the existing `watch(() => props.open, ...)` block (`:142-154`), and included in the `save()` PATCH payload (`:190-201`). No existing Vue component in this app has an established checkbox pattern to match (checked — the one `x-checkbox` convention found is a server-rendered Blade component, not applicable here), so render it directly with daisyUI's plain checkbox class, consistent with this file's existing daisyUI-flavoured classes (`input-bordered`, `btn2`, `btn-primary`):
```html
<label class="flex items-start gap-2 text-xs font-semibold uppercase tracking-wide text-neutral-content">
    <input v-model="form.legacy_pins" type="checkbox" class="checkbox checkbox-sm mt-0.5" />
    <span class="flex flex-col gap-1">
        {{ i18n.legacy_pins }}
        <span class="normal-case font-normal text-neutral-content/70">{{ i18n.legacy_pins_help }}</span>
    </span>
</label>
```

**4. `MapExplorer.vue`.** Pass `:legacy-pins="data.map.settings?.legacy_pins"` to `<LeafletCanvas>` alongside its other props. No new handler needed — `handleSettingsSaved` already replaces `data.map` wholesale, so the new prop value flows through reactively on save.

**5. `LeafletCanvas.vue`.**
- New prop: `legacyPins: { type: Boolean, default: false }`.
- `pinIcon(pin)` branches at the top on `props.legacyPins`:
  - `true`: restore the pre-restyle teardrop renderer — `marker-pin` div (background-colour `pin.colour`, `pin_size` default 40px, rotated -45deg), FA/html/svg icon layered on top, avatar photo via the counter-rotated `::after` background-image trick, `iconAnchor: [size / 2, size + size / 4]`.
  - `false`: keep the new bare-icon renderer as-is (default `24px`, `fa-location-pin` for the default pin anchored at its tip, other icons/avatars/images center-anchored, base-content stroke, colour-matched dashed draft outline).
- Add `watch(() => props.legacyPins, () => { if (leafletMap) buildPins() })`, matching the existing `watch(() => props.pins, ...)` pattern (`:513-517`), so toggling the Settings-panel checkbox and saving re-renders all pins immediately for the editor.
- Both CSS blocks coexist in the `<style>` section, naturally scoped since they target disjoint class names (`.marker-pin`/`.marker-pin::after` for legacy vs. `.marker-icon`/`.marker-avatar`/`.marker-image` for the new style); the legacy `.marker-draft .marker-pin` dashed-white outline rule is restored unchanged alongside the new style's colour-matched draft outline rule.

## Testing

Backend: extend/add a Pest feature test on `SettingsController::update` (or wherever the existing grid/zoom/distance settings round-trip is already tested) covering `legacy_pins`: saving `true` persists into `Map::config` and is echoed back as `true` in the `MapResource` `settings` payload; omitting it (or an existing map created before this feature) reads back as `false`.

Frontend: no existing Vue component test harness in this repo (only plain-JS unit tests for non-component modules like `resources/js/maps/polygon.test.js`) — matches the established pattern for every other v4 map explorer change on this branch. Verification is manual: toggle the checkbox on, save, confirm pins immediately re-render in the legacy teardrop style with no page reload; toggle off, confirm they revert to the new bare-icon style; reload the page after each to confirm persistence; spot-check all icon variants (default pin, other FA shape choices, avatar, custom uploaded image) render correctly in both styles.

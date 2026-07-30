# Map Marker "Explore" Link Design

## Goal

Restore a legacy parity gap in the Vue map explorer's `DetailPanel.vue`: when a pin's linked entity is itself a Map, or is a Location with one or more attached maps, show a prominent "Explore {name}" button that navigates into that map's own explore page — matching `resources/views/maps/markers/details.blade.php`'s existing behavior on the legacy map page.

## Out of Scope

- Any other legacy-vs-new-explorer parity gap not explicitly reported by the user.
- Changing the legacy Blade page itself — it already has this feature and keeps working as-is.

## Background

The legacy marker popup (`resources/views/maps/markers/details.blade.php`) shows an "Explore" link/button whenever `$marker->entity->isMap()` is true (pointing at `route('entities.map', [$campaign, $marker->entity])`), and separately shows one "Explore {map->name}" button per attached map when `$marker->entity->isLocation()` and `$marker->entity->child->maps` is non-empty. The new Vue `DetailPanel.vue` (backed by `PinPreviewResource`) has neither — it only shows a generic "linked entry" link to the entity's regular overview page (`entity_url`).

Per user direction, always label the button "Explore {name}" (never a bare "Explore") to remove ambiguity about what will happen — including for the direct Map-entity case, where `{name}` is the map entity's own name.

## Architecture

### Backend

**`app/Http/Resources/Maps/Explore/PinPreviewResource.php`**: add `use App\Traits\CampaignAware;` (the same fluent `->campaign($campaign)` pattern already used by `PinResource`/`MapResource`/`PresetResource`), and a new `explore_maps` field:

```php
'explore_maps' => $this->exploreMaps($entity),
```

```php
/**
 * @return array<int, array{name: string, url: string}>
 */
protected function exploreMaps(?Entity $entity): array
{
    if (! $entity) {
        return [];
    }

    if ($entity->isMap()) {
        return [['name' => $entity->name, 'url' => route('entities.map', [$this->campaign->id, $entity->id])]];
    }

    if ($entity->isLocation() && $entity->child && ! $entity->child->maps->isEmpty()) {
        return $entity->child->maps
            ->map(fn ($map) => ['name' => $map->name, 'url' => route('entities.map', [$this->campaign->id, $map->entity->id])])
            ->all();
    }

    return [];
}
```

`name` is always populated (never `null`) — the map entity's own name for the direct case, each attached map's name for the Location case — so the frontend never needs a bare-"Explore" fallback string.

**`app/Http/Controllers/Entity/Maps/MarkerController.php::preview()`**: change `new PinPreviewResource($mapMarker)` to `new PinPreviewResource($mapMarker)->campaign($campaign)` (the method already receives `$campaign` as a route param — just needs threading into the resource, exactly like `store()`/`update()` already do for `PinResource`).

**i18n**: one new key, `explore_map` = `'Explore :name'`, under `maps/explorer.marker` in `lang/en/maps/explorer.php` (colocated with `linked_entry`), wired into `ExploreApiService::translations()` as a flat `i18n.explore_map` entry (matching the existing `placement_after`-style `:name` interpolation convention already used in `GroupModal.vue`).

### Frontend

**`resources/js/components/maps/DetailPanel.vue`**: new block immediately after the existing `entity_url` linked-entry `<a>` card (after line 118, before the `marker_entry`/`entity_entry` blocks) — a `v-for` over `preview.explore_maps`, each rendered as a full-width primary button:

```html
<a
    v-for="mapLink in preview.explore_maps"
    :key="mapLink.url"
    :href="mapLink.url"
    class="btn2 btn-primary btn-block"
>
    <i class="fa-regular fa-map" aria-hidden="true" />
    {{ i18n.explore_map.replace(':name', mapLink.name) }}
</a>
```

No new props/emits needed — `preview` and `i18n` are already available in this component's scope.

## Testing

**Backend (Pest)**: extend `tests/Feature/Entities/Maps/MarkerControllerTest.php` — it already covers `entities.map-markers.preview` (e.g. `it('returns a preview for a marker with an entity, group, and entries', ...)` at line 9) —
- A pin linked to a Map entity: `explore_maps` is `[{name: <map entity name>, url: route('entities.map', ...)}]`.
- A pin linked to a Location entity with two attached maps: `explore_maps` has two entries, correct names/urls, in the Location's `maps` relation order.
- A pin linked to a Location entity with no attached maps: `explore_maps` is `[]`.
- A pin linked to a non-Map, non-Location entity (e.g. a Character): `explore_maps` is `[]`.
- A pin with no linked entity at all: `explore_maps` is `[]`.

**Frontend**: no automated component-interaction coverage exists for this app's Vue map explorer (established pattern) — verify by hand: open a pin linked to a map, confirm the "Explore {name}" button appears and navigates correctly; open a pin linked to a Location with attached maps, confirm one button per map; open a pin with no map link, confirm no button renders.

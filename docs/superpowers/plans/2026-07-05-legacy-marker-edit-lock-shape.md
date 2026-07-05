# Legacy Marker Edit Form: Lock Shape Type Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** On the legacy map marker edit form, remove the shape-switching tab UI (a marker's shape becomes fixed once created) and show that marker's shape-specific fields inline instead. The create form is untouched.

**Architecture:** Split the currently dual-purpose `resources/views/maps/markers/_form.blade.php` (used by both create and edit) into three files: the existing file stays create-only and gets simplified once edit stops depending on it, a new `_form_edit.blade.php` shows inline shape fields for editing, and a new `_form_common_fields.blade.php` holds the fields shared by both (name, entry, CSS class, opacity, background colour, group, tooltip, visibility, lat/long).

**Tech Stack:** Laravel 11 Blade templates. No PHP model/controller changes, no JS changes (verified — see Global Constraints), no automated Blade-rendering test coverage exists in this app.

## Global Constraints

- The create form (`create.blade.php`) and the two quick-add dialogs (`explore.blade.php`, `form/_markers.blade.php`) all pass `model => null` to `_form.blade.php` — none of them are affected by any task in this plan; verify each stays visually and functionally identical after Task 4.
- No changes to `resources/js/location/map-v3.js`. Verified: `initTabs()`, `initCircle()`, `initPolygonDrawing()` each early-return when their trigger element (`#marker-pin`, `select[name="size_id"]`, `#start-drawing-polygon`) is absent from the DOM — this is already exactly what happens today when editing (e.g. `#start-drawing-polygon` never renders today when `isset($model)` is true either). Removing the tab markup from the edit form changes no JS behavior.
- No changes to `edit.blade.php`'s Leaflet script block (`window.polygon.enableEdit()` etc., lines 84-91) — dragging an existing circle/polygon/path's shape on the map continues to work exactly as today, unrelated to this plan's Blade-only changes.
- No changes to any field's validation, casts, or wire format — this is a pure template restructure.
- No new premium/boost gating beyond what already exists for polygon and path.
- Every step in this plan is Blade-only; "tests" are `vendor/bin/sail artisan view:cache` (catches Blade syntax errors) plus a described manual verification, since no automated Blade-rendering tests exist in this codebase.

---

### Task 1: Extract the shared main-fields block into its own partial

**Files:**
- Create: `resources/views/maps/markers/_form_common_fields.blade.php`
- Modify: `resources/views/maps/markers/_form.blade.php:207-274`

**Interfaces:**
- Consumes: the same variables already in scope wherever `_form.blade.php` is included (`$model`, `$source`, `$map`).
- Produces: an includable partial `maps.markers._form_common_fields` with no required parameters (relies on ambient `$model`/`$source`/`$map`, exactly as the block did before extraction) — used by both `_form.blade.php` (Task 1) and the new `_form_edit.blade.php` (Task 2).

- [ ] **Step 1: Create the new partial with the extracted block**

Create `resources/views/maps/markers/_form_common_fields.blade.php` with exactly this content (copied verbatim from `_form.blade.php`'s current lines 207-274):

```blade
<div id="marker-main-fields" class="flex flex-col gap-5 w-full">
    <x-grid>
        <x-forms.field field="name" :label="__('crud.fields.name')">
            <input type="text" name="name" maxlength="191" placeholder="{{ __('maps/markers.placeholders.name') }}" value="{!! htmlspecialchars(old('name', $source->name ?? $model->name ?? null)) !!}" id="name" />
        </x-forms.field>

        @include('cruds.fields.entity')

        @if (!isset($model))
            <div class="md:col-span-2">
                <x-alert type="info">
                    {{ __('maps/markers.hints.entry') }}
                </x-alert>
            </div>
        @else
        <div class="md:col-span-2 {{ ($model->hasEntry() ? 'hidden' : '') }}">
            <a href="#" class="map-marker-entry-click text-link">{{ __('maps/markers.actions.entry') }}</a>
        </div>
        <div class="md:col-span-2 map-marker-entry-entry {{ (!$model->hasEntry() ? 'hidden' : '') }}" style="">
            <x-forms.field field="entry" :label=" __('fields.description.label')">
                @include('cruds.fields.entry', ['model' => $model])
            </x-forms.field>
        </div>
        @endif

        <x-forms.field
            field="css"
            :label="__('dashboard.widgets.fields.class')"
            :helper="__('maps/markers.helpers.css')"
        >
        <input type="text" name="css" value="{{ old('css', $model->css ?? $source->css ?? null) }}" class="w-full"
                maxlength="45" id="css"/>
        <p class="text-neutral-content md:hidden">
            {{ __('maps/markers.helpers.css') }}
        </p>

        </x-forms.field>
        @include('maps.markers.fields.opacity')

        <div class="" id="map-marker-bg-colour" @if((isset($model) && $model->isLabel()) || (isset($source) && $source->isLabel())) style="display: none;"@endif>
            @include('maps.markers.fields.background_colour')
        </div>

        <x-forms.field field="group" :label="__('maps/markers.fields.group')">
            <x-forms.select name="group_id" :options="$map->groupOptions()" :selected="$source->group_id ?? $model->group_id ?? null" id="group_id" />
        </x-forms.field>

        <x-forms.field field="is_popupless" :label="__('maps/markers.fields.popupless')">
            <input type="hidden" name="is_popupless" value="0" />
            <x-checkbox :text="__('maps/markers.helpers.is_popupless')">
                <input type="checkbox" name="is_popupless" value="1" @if ($source->is_popupless ?? old('is_popupless', $model->is_popupless ?? false)) checked="checked" @endif />
            </x-checkbox>
        </x-forms.field>

        @include('cruds.fields.visibility_id')

    </x-grid>

    <x-grid :hidden="!$model && empty($source)">
        <x-forms.field field="latitude" :label="__('maps/markers.fields.latitude')">
            <input type="number" name="latitude" value="{{ \App\Facades\FormCopy::field('latitude')->string() ?: old('latitude', $model->latitude ?? null) }}" id="marker-latitude" step="0.001" />
        </x-forms.field>

        <x-forms.field field="longitude" :label="__('maps/markers.fields.longitude')">
            <input type="number" name="longitude" value="{{ \App\Facades\FormCopy::field('longitude')->string() ?: old('longitude', $model->longitude ?? null) }}" id="marker-longitude" step="0.001" />
        </x-forms.field>
    </x-grid>
</div>
```

- [ ] **Step 2: Replace the extracted block in `_form.blade.php` with an include**

In `resources/views/maps/markers/_form.blade.php`, replace lines 207-274 (the entire block just copied above, from `<div id="marker-main-fields" ...>` through its matching closing `</div>`) with:

```blade
@include('maps.markers._form_common_fields')
```

- [ ] **Step 3: Verify Blade compiles**

Run: `vendor/bin/sail artisan view:cache`
Expected: `Blade templates cached successfully.`

Then run: `vendor/bin/sail artisan view:clear`
Expected: `Compiled views cleared successfully.`

- [ ] **Step 4: Manually verify no visual change**

Load the legacy marker create form (`/w/{campaign}/maps/{map}/map_markers/create`) and an existing marker's edit form. Confirm every field that was in the "main fields" section (name, entry, CSS class, opacity, background colour, group, tooltip popup, visibility, latitude, longitude) still renders identically on both pages — this step is a pure extraction, nothing should look or behave differently yet.

- [ ] **Step 5: Commit**

```bash
git add resources/views/maps/markers/_form_common_fields.blade.php resources/views/maps/markers/_form.blade.php
git commit -m "refactor: extract marker form's shared main-fields section into its own partial"
```

---

### Task 2: Create the edit-only inline form partial

**Files:**
- Create: `resources/views/maps/markers/_form_edit.blade.php`

**Interfaces:**
- Consumes: `$model` (always a real `MapMarker` — this file is only ever included from `edit.blade.php`), `$map`, `$campaign`, `$from` (optional), and the `maps.markers._form_common_fields` partial from Task 1.
- Produces: an includable partial `maps.markers._form_edit`, not yet referenced by anything (wired up in Task 3).

- [ ] **Step 1: Create the new file**

Create `resources/views/maps/markers/_form_edit.blade.php` with exactly this content:

```blade
<?php
/** @var \App\Models\MapMarker $model */

$sizeOptions = [
    1 => __('maps/markers.circle_sizes.tiny'),
    2 => __('maps/markers.circle_sizes.small'),
    3 => __('maps/markers.circle_sizes.standard'),
    4 => __('maps/markers.circle_sizes.large'),
    5 => __('maps/markers.circle_sizes.huge'),
    6 => __('maps/markers.circle_sizes.custom'),
];
?>

<div id="marker-shape-fields" class="flex flex-col gap-5 w-full">
    @if ($model->isLabel())
        <x-helper>
            <p>{{ __('maps/markers.helpers.label') }}</p>
        </x-helper>
    @elseif ($model->isCircle())
        <x-grid>
            <x-forms.field field="size" :label="__('maps/markers.fields.size')">
                <x-forms.select name="size_id" :options="$sizeOptions" :selected="$model->size_id ?? null" id="size_id" />
            </x-forms.field>

            <x-forms.field field="radius" :label="__('maps/markers.fields.circle_radius')">
                <input type="text" name="circle_radius" value="{{ old('circle_radius', $model->circle_radius ?? null) }}" class="w-full map-marker-circle-radius" id="circle_radius" />
                <div class="map-marker-circle-helper">
                    <x-helper>
                        <p>{{ __('maps/markers.helpers.custom_radius') }}</p>
                    </x-helper>
                </div>
            </x-forms.field>
        </x-grid>
    @elseif ($model->isPolygon())
        <x-grid>
            <div class="field field-shape flex flex-col gap-2 col-span-2">
                @if ($campaign->boosted())
                    <div class="flex">
                        <div class="grow field">
                            <label>{{ __('maps/markers.fields.custom_shape') }}</label>
                            <x-helper>
                                <p>{{ __('maps/markers.helpers.polygon.edit') }}</p>
                            </x-helper>
                        </div>
                        <a href="#" id="reset-polygon" class="btn2 btn-error btn-outline btn-sm">
                            <x-icon class="fa-regular fa-eraser" />
                            {{ __('maps/markers.actions.reset-polygon') }}
                        </a>
                    </div>
                    <textarea name="custom_shape" class="w-full" rows="2" placeholder="{{ __('maps/markers.placeholders.custom_shape') }}">{{ old('custom_shape', $model->custom_shape ?? null) }}</textarea>
                @else
                    <x-premium-cta :campaign="$campaign">
                        <p>{{ __('maps/markers.pitches.poly') }}</p>
                    </x-premium-cta>
                @endif
            </div>

            <x-forms.field field="stroke" :label="__('maps/markers.fields.polygon_style.stroke')">
                <span>
                <input type="text" name="polygon_style[stroke]" value="{{ old('polygon_style[stroke]', $model->polygon_style['stroke'] ?? null) }}" class="w-full spectrum" maxlength="7" data-append-to="#marker-modal" />
                </span>
            </x-forms.field>

            <x-forms.field field="width" :label="__('maps/markers.fields.polygon_style.stroke-width')">
                <input type="number" name="polygon_style[stroke-width]" value="{{ old('polygon_style[stroke-width]', $model->polygon_style['stroke-width'] ?? null) }}" id="stroke-width" step="1" min="0" max="99" maxlength="2" />
            </x-forms.field>

            <x-forms.field field="opacity" :label="__('maps/markers.fields.polygon_style.stroke-opacity')">
                <input type="number" name="polygon_style[stroke-opacity]" value="{{ old('polygon_style[stroke-opacity]', $model->polygon_style['stroke-opacity'] ?? null) }}" id="stroke-opacity" step="10" min="0" max="100" maxlength="3" />
            </x-forms.field>
        </x-grid>
    @elseif ($model->isPath())
        <x-grid>
            @if ($campaign->boosted())
                <div class="field field-shape flex flex-col gap-2 col-span-2">
                    <label>{{ __('maps/markers.fields.custom_shape') }}</label>
                    <x-helper>
                        <p>{{ __('maps/markers.helpers.path.edit') }}</p>
                    </x-helper>
                    <textarea name="custom_shape" class="w-full" rows="2" placeholder="{{ __('maps/markers.placeholders.custom_shape') }}">{{ old('custom_shape', $model->custom_shape ?? null) }}</textarea>
                </div>

                <x-forms.field field="width" :label="__('maps/markers.fields.polygon_style.stroke-width')">
                    <input type="number" name="polygon_style[stroke-width]" value="{{ $model->polygon_style['stroke-width'] ?? old('polygon_style[stroke-width]') }}" id="path-stroke-width" step="1" min="1" max="99" maxlength="2" />
                </x-forms.field>
            @else
                <div class="field field-shape flex flex-col gap-2 col-span-2">
                    <x-premium-cta :campaign="$campaign">
                        <p>{{ __('maps/markers.pitches.path') }}</p>
                    </x-premium-cta>
                </div>
            @endif
        </x-grid>
    @else
        <x-grid>
            @include('maps.markers.fields.icon')
            @include('maps.markers.fields.custom_icon')

            @include('maps.markers.fields.pin_size')
            @include('maps.markers.fields.font_colour')

            <x-forms.field field="draggable" css="" :label="__('maps/markers.fields.is_draggable')">
                <input type="hidden" name="is_draggable" value="0" />
                <x-checkbox :text="__('maps/markers.helpers.draggable')">
                    <input type="checkbox" name="is_draggable" value="1" @if (old('is_draggable', $model->is_draggable ?? false)) checked="checked" @endif />
                </x-checkbox>
            </x-forms.field>
        </x-grid>
    @endif
</div>

@include('maps.markers._form_common_fields')

<input type="hidden" name="shape_id" value="{{ $model->shape_id }}" />
@if (isset($from))
    <input type="hidden" name="from" value="{{ $from }}" />
@endif
@include('editors.editor')
```

Note the `@elseif` chain order (label, circle, polygon, path, else-plain-pin) matches `MapMarker::marker()`'s own shape-check order — mutually exclusive checks, so order has no functional effect, kept for consistency with the rest of the codebase.

- [ ] **Step 2: Verify Blade compiles**

Run: `vendor/bin/sail artisan view:cache`
Expected: `Blade templates cached successfully.` (this file is not yet included anywhere, but this catches any syntax error in it immediately.)

Then run: `vendor/bin/sail artisan view:clear`

- [ ] **Step 3: Commit**

```bash
git add resources/views/maps/markers/_form_edit.blade.php
git commit -m "feat: add an inline, tab-free marker fields partial for the edit form"
```

---

### Task 3: Wire the edit form to the new inline partial

**Files:**
- Modify: `resources/views/maps/markers/edit.blade.php:37`

**Interfaces:**
- Consumes: `maps.markers._form_edit` (Task 2).
- Produces: the edit form now shows inline shape fields with a fixed shape — this is the user-visible switch-over for this plan.

- [ ] **Step 1: Change the include**

In `resources/views/maps/markers/edit.blade.php`, change:

```blade
                @include('maps.markers._form')
```

to:

```blade
                @include('maps.markers._form_edit')
```

- [ ] **Step 2: Verify Blade compiles**

Run: `vendor/bin/sail artisan view:cache`
Expected: `Blade templates cached successfully.`

Then run: `vendor/bin/sail artisan view:clear`

- [ ] **Step 3: Manually verify each shape's edit form**

Using an existing marker of each shape (create test markers via `vendor/bin/sail artisan tinker` if needed, following this session's established pattern — `CampaignLocalization::forceCampaign()`, a factory-created `is_real` map, boosting `boost_count` temporarily for polygon/path):

- Plain pin marker: edit form shows icon/custom icon/pin size/font colour/draggable fields inline, no tab bar anywhere.
- Label marker: shows the label helper text only.
- Circle marker: shows size dropdown + circle radius field inline; dragging the circle on the map still works and still saves (unaffected `edit.blade.php` script block).
- Polygon marker (boosted campaign): shows shape textarea + reset button + stroke colour/width/opacity fields inline; dragging a vertex still works and still saves.
- Polygon marker (non-boosted campaign): shows the premium CTA instead of the shape fields.
- Path marker (boosted campaign): shows shape textarea + stroke width field inline; dragging a point still works and still saves.
- Path marker (non-boosted campaign): shows the premium CTA instead.
- For every shape: the hidden `shape_id` field's value matches the marker's actual shape, and there is no way to change it via the UI.
- Saving the form (unchanged fields) still succeeds and doesn't alter the marker's shape or geometry.

- [ ] **Step 4: Commit**

```bash
git add resources/views/maps/markers/edit.blade.php
git commit -m "feat: lock a marker's shape on the legacy edit form"
```

---

### Task 4: Simplify the create-only form to drop now-dead edit-only branches

**Files:**
- Modify: `resources/views/maps/markers/_form.blade.php`

**Interfaces:**
- Consumes: nothing new.
- Produces: `_form.blade.php` is now guaranteed create-only (its 3 remaining callers — `create.blade.php`, `explore.blade.php`, `form/_markers.blade.php` — all pass `model => null`), so its `isset($model)` branches for editing are unreachable dead code, removed here.

- [ ] **Step 1: Remove the path tab entirely**

In `resources/views/maps/markers/_form.blade.php`, remove the path tab `<li>` (currently gated `@if (isset($model) && $model->isPath())`, always false now):

```blade
        @if (isset($model) && $model->isPath())
        <li role="presentation" @if($activeTab == 6) class="active" @endif>
            <a href="#marker-path" data-nohash="true"  data-toggle="tooltip" class="text-center" data-title="{{ __('maps/markers.tabs.path') }}">
                <x-icon class="fa-regular fa-2x fa-route" />
                <br />
                {{ __('maps/markers.tabs.path') }}
            </a>
        </li>
        @endif
```

Delete this block entirely (it never rendered in create mode, and paths are never created via the legacy UI).

Also remove the path tab-pane, currently:

```blade
        @if (isset($model) && $model->isPath())
        <div class="tab-pane @if($activeTab == 6) active @endif" id="marker-path">
            <x-grid>
                @if ($campaign->boosted())
                    <div class="field field-shape flex flex-col gap-2 col-span-2">
                        <label>{{ __('maps/markers.fields.custom_shape') }}</label>
                        <x-helper>
                            <p>{{ __('maps/markers.helpers.path.edit') }}</p>
                        </x-helper>
                        <textarea name="custom_shape" class="w-full" rows="2" placeholder="{{ __('maps/markers.placeholders.custom_shape') }}">{!! \App\Facades\FormCopy::field('custom_shape')->string() ?: old('custom_shape', $model->custom_shape ?? null) !!}</textarea>
                    </div>

                    <x-forms.field field="width" :label="__('maps/markers.fields.polygon_style.stroke-width')">
                        <input type="number" name="polygon_style[stroke-width]" value="{{ $model->polygon_style['stroke-width'] ?? old('polygon_style[stroke-width]') }}" id="path-stroke-width" step="1" min="1" max="99" maxlength="2" />
                    </x-forms.field>
                @else
                    <div class="field field-shape flex flex-col gap-2 col-span-2">
                        <x-premium-cta :campaign="$campaign">
                            <p>{{ __('maps/markers.pitches.path') }}</p>
                        </x-premium-cta>
                    </div>
                @endif
            </x-grid>
        </div>
        @endif
```

Delete this block entirely too.

- [ ] **Step 2: Simplify the polygon tab-pane to its create-only content**

In `resources/views/maps/markers/_form.blade.php`, replace the entire polygon tab-pane, currently:

```blade
        <div class="tab-pane @if($activeTab == 5) active @endif" id="marker-poly">
            <x-grid>
                <div class="field field-shape flex flex-col gap-2 col-span-2">
                    <div class="flex">
                        <div class="grow field">
                            <label>{{ __('maps/markers.fields.custom_shape') }}</label>
                            @if ($campaign->boosted())
                                @if(isset($model))
                                    <x-helper>
                                        <p>{{ __('maps/markers.helpers.polygon.edit') }}</p>
                                    </x-helper>
                                </div>

                                <a href="#" id="reset-polygon" class="btn2 btn-error btn-outline btn-sm" style="">
                                    <x-icon class="fa-regular fa-eraser" />
                                    {{ __('maps/markers.actions.reset-polygon') }}
                                </a>
                            </div>
                                @else
                        </div>
                    </div>
                    <div>
                        <a href="#" id="start-drawing-polygon" class="btn2 btn-primary btn-sm" data-toast="{{ __('maps/explore.notifications.start-drawing') }}">
                            <x-icon class="pencil" />
                            {{ __('maps/markers.actions.start-drawing') }}
                        </a>
                        <a href="#" id="reset-polygon" class="btn2 btn-error btn-outline btn-sm hidden">
                            <x-icon class="fa-regular fa-eraser" />
                            {{ __('maps/markers.actions.reset-polygon') }}
                        </a>
                    </div>
                    @endif
                        <textarea name="custom_shape" class="w-full" rows="2" placeholder="{{ __('maps/markers.placeholders.custom_shape') }}">{!! \App\Facades\FormCopy::field('custom_shape')->string() ?: old('custom_shape', $model->custom_shape ?? null) !!}</textarea>
                    @else
                        <x-premium-cta :campaign="$campaign">
                            <p>{{ __('maps/markers.pitches.poly') }}</p>
                        </x-premium-cta>
                        </div>
                    </div>
                    @endif
                </div>

                <x-forms.field field="stroke" :label="__('maps/markers.fields.polygon_style.stroke')">
                    <span>

                    <input type="text" name="polygon_style[stroke]" value="{{ old('polygon_style[stroke]', $source->polygon_style['stroke'] ?? $model->polygon_style['stroke'] ?? null) }}" class="w-full spectrum" maxlength="7" data-append-to="#marker-modal" />
                    </span>
                </x-forms.field>

                <x-forms.field field="width" :label="__('maps/markers.fields.polygon_style.stroke-width')">
                    <input type="number" name="polygon_style[stroke-width]" value="{{ $source->polygon_style['stroke-width'] ?? old('polygon_style[stroke-width]', $model->polygon_style['stroke-width'] ?? null) }}" id="stroke-width" step="1" min="0" max="99" maxlength="2" />
                </x-forms.field>

                <x-forms.field field="opacity" :label="__('maps/markers.fields.polygon_style.stroke-opacity')">
                    <input type="number" name="polygon_style[stroke-opacity]" value="{{ $source->polygon_style['stroke-opacity'] ?? old('polygon_style[stroke-opacity]', $model->polygon_style['stroke-opacity'] ?? null) }}" id="stroke-opacity" step="10" min="0" max="100" maxlength="3" />
                </x-forms.field>
            </x-grid>
        </div>
```

with the simplified, create-only version (dropping the `isset($model)` sub-branch, and correcting a pre-existing stray extra closing `</div>` in the non-boosted branch that the old nesting had — verified by counting: the non-boosted branch only ever opened one `<div>` before its `@else`, so it must only close one):

```blade
        <div class="tab-pane @if($activeTab == 5) active @endif" id="marker-poly">
            <x-grid>
                <div class="field field-shape flex flex-col gap-2 col-span-2">
                    @if ($campaign->boosted())
                        <div>
                            <a href="#" id="start-drawing-polygon" class="btn2 btn-primary btn-sm" data-toast="{{ __('maps/explore.notifications.start-drawing') }}">
                                <x-icon class="pencil" />
                                {{ __('maps/markers.actions.start-drawing') }}
                            </a>
                            <a href="#" id="reset-polygon" class="btn2 btn-error btn-outline btn-sm hidden">
                                <x-icon class="fa-regular fa-eraser" />
                                {{ __('maps/markers.actions.reset-polygon') }}
                            </a>
                        </div>
                        <textarea name="custom_shape" class="w-full" rows="2" placeholder="{{ __('maps/markers.placeholders.custom_shape') }}">{!! \App\Facades\FormCopy::field('custom_shape')->string() ?: old('custom_shape', $model->custom_shape ?? null) !!}</textarea>
                    @else
                        <x-premium-cta :campaign="$campaign">
                            <p>{{ __('maps/markers.pitches.poly') }}</p>
                        </x-premium-cta>
                    @endif
                </div>

                <x-forms.field field="stroke" :label="__('maps/markers.fields.polygon_style.stroke')">
                    <span>

                    <input type="text" name="polygon_style[stroke]" value="{{ old('polygon_style[stroke]', $source->polygon_style['stroke'] ?? $model->polygon_style['stroke'] ?? null) }}" class="w-full spectrum" maxlength="7" data-append-to="#marker-modal" />
                    </span>
                </x-forms.field>

                <x-forms.field field="width" :label="__('maps/markers.fields.polygon_style.stroke-width')">
                    <input type="number" name="polygon_style[stroke-width]" value="{{ $source->polygon_style['stroke-width'] ?? old('polygon_style[stroke-width]', $model->polygon_style['stroke-width'] ?? null) }}" id="stroke-width" step="1" min="0" max="99" maxlength="2" />
                </x-forms.field>

                <x-forms.field field="opacity" :label="__('maps/markers.fields.polygon_style.stroke-opacity')">
                    <input type="number" name="polygon_style[stroke-opacity]" value="{{ $source->polygon_style['stroke-opacity'] ?? old('polygon_style[stroke-opacity]', $model->polygon_style['stroke-opacity'] ?? null) }}" id="stroke-opacity" step="10" min="0" max="100" maxlength="3" />
                </x-forms.field>
            </x-grid>
        </div>
```

(`$model` in this file is always null now, so `$model->custom_shape ?? null` etc. always fall through to their `$source`/`old()` fallback — kept as-is, matching the file's existing dead-fallback conventions elsewhere, not stripped out, since that would be a much larger, purely-cosmetic diff with no behavior change.)

- [ ] **Step 3: Remove the dead `editors.editor` include**

In `resources/views/maps/markers/_form.blade.php`, remove the final line:

```blade
@includeWhen(isset($model), 'editors.editor')
```

(This was always false in create context even before this plan; now that `_form.blade.php` is guaranteed create-only, it's unreachable dead code. `_form_edit.blade.php`, from Task 2, includes `editors.editor` unconditionally instead.)

- [ ] **Step 4: Verify Blade compiles**

Run: `vendor/bin/sail artisan view:cache`
Expected: `Blade templates cached successfully.`

Then run: `vendor/bin/sail artisan view:clear`

- [ ] **Step 5: Manually verify the create form and quick-add dialogs are unchanged**

- Legacy create form (`/w/{campaign}/maps/{map}/map_markers/create`): all 5 tabs present (Pin/Label/Circle/Area/Presets), no Path tab ever shown, drawing a brand-new polygon from scratch still works (`#start-drawing-polygon` button), loading a preset still works.
- Quick-add dialog on the legacy explore page (`explore.blade.php`'s marker modal): unchanged.
- Quick-add on the map's marker index page (`form/_markers.blade.php`): unchanged.

- [ ] **Step 6: Commit**

```bash
git add resources/views/maps/markers/_form.blade.php
git commit -m "refactor: drop now-dead edit-only branches from the create-only marker form"
```

---

### Task 5: End-to-end verification

**Files:** none (verification only).

- [ ] **Step 1: Run the Maps test suite to confirm no backend regressions**

```bash
vendor/bin/sail artisan test --compact tests/Feature/Entities/Maps/
```

Expected: all passing (this plan makes no backend changes, so this is a regression guard, not new coverage).

- [ ] **Step 2: Live-verify the full matrix once more, end to end**

Using the same tinker-created test fixtures pattern established earlier this session (boosted and non-boosted campaigns, one marker per shape):

1. Edit each of pin/label/circle/polygon/path markers — confirm inline fields, no tab bar, correct premium gating for polygon/path, and that saving each one persists correctly and doesn't alter its shape.
2. Confirm dragging a circle/polygon/path's existing shape on the edit page's map still works and still saves (this exercises `edit.blade.php`'s untouched script block end-to-end through the new template).
3. Confirm the create form is pixel-for-pixel unchanged: all 5 tabs, drawing a new polygon, loading a preset, submitting a new marker of each creatable shape (pin/label/circle/polygon).
4. Confirm the two quick-add dialogs still open and submit correctly.

- [ ] **Step 3: Fix forward if any check fails**

If a step above fails, return to the relevant task, fix it, re-run that task's own verification, then re-run this task's steps from the top.

- [ ] **Step 4: Final commit (if any fixes were made in Step 3)**

```bash
git add -A
git commit -m "fix: address issues found in edit-form-lock-shape end-to-end verification"
```

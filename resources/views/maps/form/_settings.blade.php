<?php
/** @var Map $model */
use App\Models\Map;
$minInitial = Map::MIN_ZOOM;
$maxInitial = Map::MAX_ZOOM_REAL;
$defaultInitial = 0;

if (isset($model) && $model->isChunked()) {
    $minInitial = Map::MIN_ZOOM_CHUNK;
    $maxInitial = Map::MAX_ZOOM_CHUNK;
    $defaultInitial = $minInitial;
}
?>
<x-grid>
    <x-forms.field
        field="real"
        :label="__('maps.fields.is_real')">
        <input type="hidden" name="is_real" value="0" />
        <x-checkbox :text="__('maps.helpers.is_real')">
            <input type="checkbox" name="is_real" value="1" @if (old('is_real', $model->is_real ?? false)) checked="checked" @endif />
        </x-checkbox>
    </x-forms.field>

    <x-forms.field
        field="clustering"
        :label="__('maps.fields.has_clustering')">
        <input type="hidden" name="has_clustering" value="0" />
        <x-checkbox :text="__('maps.helpers.has_clustering')">
            <input type="checkbox" name="has_clustering" value="1" @if (old('has_clustering', $model->has_clustering ?? true)) checked="checked" @endif />
        </x-checkbox>
    </x-forms.field>

    <hr class="m-0 col-span-2"/>

@if (isset($model) && $model->isChunked())
    <x-alert type="info">
        <p>{{ __('maps.helpers.chunked_zoom') }}</p>
    </x-alert>
@else
    <x-forms.field
        field="max-zoom"
        :label="__('maps.fields.max_zoom')"
        :helper="__('maps.helpers.max_zoom', ['max' => Map::MAX_ZOOM, 'default' => 5])">
        <input type="number" name="max_zoom" class="w-full" value="{{ FormCopy::field('max_zoom')->string() ?: old('max_zoom', $model->max_zoom ?? null) }}" maxlength="2" placeholder="5" />
    </x-forms.field>

    <x-forms.field
        field="min-zoom"
        :label="__('maps.fields.min_zoom')"
        :helper="__('maps.helpers.min_zoom', ['min' => Map::MIN_ZOOM, 'default' => -2])"
    >
        <input type="number" name="min_zoom" class="w-full" value="{{ FormCopy::field('min_zoom')->string() ?: old('min_zoom', $model->min_zoom ?? null) }}" maxlength="3" placeholder="-2" />
    </x-forms.field>
@endif

    <x-forms.field
        field="initial-zoom"
        :label="__('maps.fields.initial_zoom')"
        :helper=" __('maps.helpers.initial_zoom', ['min' => $minInitial, 'max' => $maxInitial, 'default' => $defaultInitial])">
        <input type="number" name="initial_zoom" class="w-full" value="{{ FormCopy::field('initial_zoom')->string() ?: old('initial_zoom', $model->initial_zoom ?? null) }}" maxlength="3" placeholder="5" />
    </x-forms.field>

    <x-forms.field
        field="grid"
        :label="__('maps.fields.grid')"
        :helper=" __('maps.helpers.grid')">
        <input type="number" name="grid" class="w-full" value="{{ FormCopy::field('grid')->string() ?: old('grid', $model->grid ?? null) }}" maxlength="4" placeholder="{{ __('maps.placeholders.grid') }}" />
    </x-forms.field>

    <hr class="col-span-2 m-0" />

    <x-forms.field
        field="distance-name"
        :label="__('maps.fields.distance_name')">

        <input type="text" name="config[distance_name]" value="{{ old('config[distance_name]', $source->config['distance_name'] ?? $model->config['distance_name'] ?? null) }}" class="w-full" placeholder="{{ __('maps.placeholders.distance_name') }}" maxlength="20" list="map-marker-icon-list" />
    </x-forms.field>

    <x-forms.field
        field="distance-measure"
        :label="__('maps.fields.distance_measure')"
        tooltip
        :helper="__('maps.helpers.distance_measure') . ' ' . __('maps.helpers.distance_measure_2')"
        >
        <input type="number" name="config[distance_measure]" class="w-full" value="{{ $source->config['distance_measure'] ?? old('config[distance_measure]', $model->config['distance_measure'] ?? null) }}" min="0.001" max="100.99" step="0.0001"/>
    </x-forms.field>

    <hr class="col-span-2 m-0" />

    <x-forms.field field="centering col-span-2" :label="__('maps.fields.centering') ">
        <p class="text-neutral-content">
            {{ __('maps.helpers.centering') }}
        </p>

        <div class="nav-tabs-custom">
            <ul class="nav-tabs bg-base-300 !p-1 rounded" role="tablist">
                <li class="active rounded">
                    <a data-toggle="tab" href="#coordinates">
                        {{ __('maps.fields.tabs.coordinates') }}
                    </a>
                </li>
                <li class="{{ (isset($model) && !empty($model))? '' : 'disabled cursor-' }}">
                    <a class="{{ (isset($model) && !empty($model))? '' : 'cursor-none' }}" data-toggle="tab"
                        href="#marker">
                        {{ __('maps.fields.tabs.marker') }}
                    </a>
                </li>
            </ul>
            <div class="tab-content bg-base-100 p-4">
                <div id="coordinates" class="tab-pane active">
                    <x-helper>
                        <p>{{ __('maps.helpers.center') }}</p>
                    </x-helper>
                    <x-grid>
                        <x-forms.field field="center-y" :label="__('maps.fields.center_y')">
                            <input type="number" name="center_y" class="w-full" value="{{ FormCopy::field('center_y')->string() ?: old('center_y', $model->center_y ?? null) }}" min="-90" step="0.001" placeholder="{{ __('maps.placeholders.center_y') }}" />
                        </x-forms.field>

                        <x-forms.field field="center-x" :label="__('maps.fields.center_x')">
                            <input type="number" name="center_x" class="w-full" value="{{ FormCopy::field('center_x')->string() ?: old('center_x', $model->center_x ?? null) }}" min="-180" step="0.001" placeholder="{{ __('maps.placeholders.center_x') }}" />
                        </x-forms.field>
                    </x-grid>
                </div>
                <div id="marker" class="tab-pane">
                    @if (isset($model) && !empty($model))
                    <?php
                        //get the current center marker or null
                        $preset = null;
                        if (isset($model) && $model->centerMarker) {
                            $preset = $model->centerMarker;
                        }
                    ?>
                    <x-forms.foreign
                        name="center_marker_id"
                        :label="__('maps.fields.center_marker')"
                        :placeholder="__('maps.placeholders.center_marker')"
                        :allowClear="true"
                        :route="route('markers.find', [$campaign, 'include' => $model->id])"
                        :selected="$preset">
                    </x-forms.foreign>
                    @else
                        <p class="text-neutral-content">
                            Add markers to the map first.
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </x-forms.field>
</x-grid>

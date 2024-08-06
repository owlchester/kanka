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

<div class="nav-tabs-custom">
    <ul class="nav-tabs bg-base-300 !p-1 rounded" role="tablist">
        <li role="presentation" @if($activeTab == 1) class="active" @endif>
            <a href="#marker-pin" data-nohash="true" data-toggle="tooltip" class="text-center" data-title="{{ __('maps/markers.tabs.marker') }}">
                <x-icon class="fa-solid fa-2x fa-map-pin" />
                <br />
                {{ __('maps/markers.tabs.marker') }}
            </a>
        </li>
        <li role="presentation" @if($activeTab == 2) class="active" @endif>
            <a href="#marker-label" data-nohash="true"  data-toggle="tooltip" class="text-center" data-title="{{ __('maps/markers.tabs.label') }}">
                <x-icon class="fa-solid fa-2x fa-font" />
                <br />
                {{ __('maps/markers.tabs.label') }}
            </a>
        </li>
        <li role="presentation" @if($activeTab == 3) class="active" @endif>
            <a href="#marker-circle" data-nohash="true"  data-toggle="tooltip" class="text-center" data-title="{{ __('maps/markers.tabs.circle') }}">
                <x-icon class="fa-regular fa-2x fa-circle" />
                <br />
                {{ __('maps/markers.tabs.circle') }}
            </a>
        </li>
        <li role="presentation" @if($activeTab == 5) class="active" @endif>
            <a href="#marker-poly" data-nohash="true"  data-toggle="tooltip" class="text-center" data-title="{{ __('maps/markers.tabs.polygon') }}">
                <x-icon class="fa-solid fa-2x fa-draw-polygon" />
                <br />
                {{ __('maps/markers.tabs.polygon') }}
            </a>
        </li>
        <li role="presentation">
            <a href="#presets" data-nohash="true" class="text-center" data-presets="{{ route('preset_types.presets.index', [$campaign, 'preset_type' => \App\Models\PresetType::MARKER, 'from' => $from ?? null]) }}">
                <x-icon class="fa-solid fa-2x fa-wand-magic-sparkles" />
                <br />
                {{ __('maps/markers.tabs.preset') }}
            </a>
        </li>
    </ul>

    <div class="tab-content bg-base-100 shadow-sm rounded mb-5 p-4 rounded-bl rounded-br w-full">
        <div class="tab-pane @if($activeTab == 1) active @endif" id="marker-pin">
            <x-grid>
                @include('maps.markers.fields.icon')
                @include('maps.markers.fields.custom_icon')

                @include('maps.markers.fields.pin_size')
                @include('maps.markers.fields.font_colour')

                <x-forms.field field="draggable" css="" :label="__('maps/markers.fields.is_draggable')">
                    <input type="hidden" name="is_draggable" value="0" />
                    <x-checkbox :text="__('maps/markers.helpers.draggable')">
                        <input type="checkbox" name="is_draggable" value="1" @if (old('is_draggable', $source->is_draggable ?? $model->is_draggable ?? false)) checked="checked" @endif />
                    </x-checkbox>
                </x-forms.field>
            </x-grid>
        </div>
        <div class="tab-pane @if($activeTab == 2) active @endif" id="marker-label">
            <x-helper>{{ __('maps/markers.helpers.label') }}</x-helper>
        </div>
        <div class="tab-pane @if($activeTab == 3) active @endif" id="marker-circle">
            <x-grid>
                <x-forms.field field="size" :label="__('maps/markers.fields.size')">
                    <x-forms.select name="size_id" :options="$sizeOptions" :selected="$source->size_id ?? $model->size_id ?? null" id="size_id" />
                </x-forms.field>

                <x-forms.field field="radius" :label="__('maps/markers.fields.circle_radius')">
                    <input type="text" name="circle_radius" value="{{ old('circle_radius', $source->circle_radius ?? $model->circle_radius ?? null) }}" class="w-full map-marker-circle-radius {{ ($source?->isCircle() ?? $model?->isCircle() ?? false) ? null : 'hidden' }}" id="circle_radius" />
                    <div class="map-marker-circle-helper">
                        <x-helper :text="__('maps/markers.helpers.custom_radius')" />
                    </div>
                </x-forms.field>
            </x-grid>
        </div>
        <div class="tab-pane @if($activeTab == 5) active @endif" id="marker-poly">
            <x-grid>
                <div class="field field-shape flex flex-col gap-2 col-span-2">
                    <div class="flex">
                        <div class="grow field">
                            <label>{{ __('maps/markers.fields.custom_shape') }}</label>
                            @if ($campaign->boosted())
                                @if(isset($model))
                                    <x-helper>
                                        {{ __('maps/markers.helpers.polygon.edit') }}
                                    </x-helper>
                                </div>

                                <a href="#" id="reset-polygon" class="btn2 btn-error btn-outline btn-sm" style="">
                                    <x-icon class="fa-solid fa-eraser" />
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
                            <x-icon class="fa-solid fa-eraser" />
                            {{ __('maps/markers.actions.reset-polygon') }}
                        </a>
                    </div>
                    @endif
                        <textarea name="custom_shape" class="w-full" rows="2" placeholder="{{ __('maps/markers.placeholders.custom_shape') }}">{!! \App\Facades\FormCopy::field('custom_shape')->string() ?: old('custom_shape', $model->custom_shape ?? null) !!}</textarea>
                    @else
                        <x-cta :campaign="$campaign" image="0">
                            <p>{{ __('maps/markers.pitches.poly') }}</p>
                        </x-cta>
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

        <div class="tab-pane pane-presets" id="presets">
            <x-grid type="1/1">
                <x-helper>
                    {!! __('maps/markers.presets.helper') !!}
                </x-helper>

                <div class="marker-preset-list rounded">
                    <div class="text-center">
                        <x-icon class="load" />
                    </div>
                </div>

                @can('mapPresets', $campaign)
                    <a href="{{ route('preset_types.presets.create', [$campaign, 'preset_type' => \App\Models\PresetType::MARKER, 'from' => $from ?? null]) }}" class="btn2 btn-primary btn-sm">
                        {{ __('presets.actions.create') }}
                    </a>
                @endcan
            </x-grid>
        </div>
    </div>
</div>

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
            <a href="#" class="map-marker-entry-click">{{ __('maps/markers.actions.entry') }}</a>
        </div>
        <div class="md:col-span-2 map-marker-entry-entry {{ (!$model->hasEntry() ? 'hidden' : '') }}" style="">
            <x-forms.field field="entry" :label=" __('crud.fields.entry')">
                <textarea name="entry" class="w-full html-editor" id="marker-entry" rows="3">{!! \App\Facades\FormCopy::field('entry')->string() ?: old('entry', $model->entry ?? null) !!}</textarea>
            </x-forms.field>
        </div>
        @endif

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

<input type="hidden" name="shape_id" value="{{ $source->shape_id ?? $model->shape_id ?? 1 }}" />
@if (isset($from))
    <input type="hidden" name="from" value="{{ $from }}" />
@endif
@includeWhen(isset($model), 'editors.editor')

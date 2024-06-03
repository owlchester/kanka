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
                <x-icon class="fa-solid fa-2x fa-map-pin"></x-icon>
                <br />
                {{ __('maps/markers.tabs.marker') }}
            </a>
        </li>
        <li role="presentation" @if($activeTab == 2) class="active" @endif>
            <a href="#marker-label" data-nohash="true"  data-toggle="tooltip" class="text-center" data-title="{{ __('maps/markers.tabs.label') }}">
                <x-icon class="fa-solid fa-2x fa-font"></x-icon>
                <br />
                {{ __('maps/markers.tabs.label') }}
            </a>
        </li>
        <li role="presentation" @if($activeTab == 3) class="active" @endif>
            <a href="#marker-circle" data-nohash="true"  data-toggle="tooltip" class="text-center" data-title="{{ __('maps/markers.tabs.circle') }}">
                <x-icon class="fa-regular fa-2x fa-circle"></x-icon>
                <br />
                {{ __('maps/markers.tabs.circle') }}
            </a>
        </li>
        <li role="presentation" @if($activeTab == 5) class="active" @endif>
            <a href="#marker-poly" data-nohash="true"  data-toggle="tooltip" class="text-center" data-title="{{ __('maps/markers.tabs.polygon') }}">
                <x-icon class="fa-solid fa-2x fa-draw-polygon"></x-icon>
                <br />
                {{ __('maps/markers.tabs.polygon') }}
            </a>
        </li>
        <li role="presentation">
            <a href="#presets" data-nohash="true" class="text-center" data-presets="{{ route('preset_types.presets.index', [$campaign, 'preset_type' => \App\Models\PresetType::MARKER, 'from' => $from ?? null]) }}">
                <x-icon class="fa-solid fa-2x fa-wand-magic-sparkles"></x-icon>
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
                        {!! Form::checkbox('is_draggable', 1, (!empty($source) ? $source->is_draggable : null)) !!}
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
                    {!! Form::select('size_id', $sizeOptions, \App\Facades\FormCopy::field('size_id')->string(), ['class' => '', 'id' => 'size_id']) !!}
                </x-forms.field>

                <x-forms.field field="radius" :label="__('maps/markers.fields.circle_radius')">
                    {!! Form::text('circle_radius', \App\Facades\FormCopy::field('circle_radius')->string(), ['class' => ' map-marker-circle-radius', 'id' => 'circle_radius', 'style' => (!isset($model) || $model->shape_id != 6) ? 'display:none;' : '']) !!}
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
                                    <i class="fa-solid fa-eraser" aria-hidden="true"></i>
                                    {{ __('maps/markers.actions.reset-polygon') }}
                                </a>
                            </div>
                                @else
                        </div>
                    </div>
                    <div>
                        <a href="#" id="start-drawing-polygon" class="btn2 btn-primary btn-sm" data-toast="{{ __('maps/explore.notifications.start-drawing') }}">
                            <x-icon class="pencil"></x-icon>
                            {{ __('maps/markers.actions.start-drawing') }}
                        </a>
                        <a href="#" id="reset-polygon" class="btn2 btn-error btn-outline btn-sm" style="display: none">
                            <x-icon class="fa-solid fa-eraser"></x-icon>
                            {{ __('maps/markers.actions.reset-polygon') }}
                        </a>
                    </div>
                    @endif
                        {!! Form::textarea('custom_shape', \App\Facades\FormCopy::field('custom_shape')->string(), ['class' => '', 'rows' => 2, 'placeholder' => __('maps/markers.placeholders.custom_shape')]) !!}
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
                    {!! Form::text('polygon_style[stroke]', \App\Facades\FormCopy::field('polygon_style[stroke]')->string(), ['class' => ' spectrum']) !!}
                    </span>
                </x-forms.field>

                <x-forms.field field="width" :label="__('maps/markers.fields.polygon_style.stroke-width')">
                    {!! Form::number('polygon_style[stroke-width]', \App\Facades\FormCopy::field('polygon_style[stroke-width]')->string(), ['class' => '', 'maxlength' => 2, 'step' => 1, 'max' => 99, 'min' => 0, 'id' => 'stroke-width']) !!}
                </x-forms.field>

                <x-forms.field field="opacity" :label="__('maps/markers.fields.polygon_style.stroke-opacity')">
                    {!! Form::number('polygon_style[stroke-opacity]', \App\Facades\FormCopy::field('polygon_style[stroke-opacity]')->string(), [
                    'maxlength' => 3,
                    'step' => 10,
                    'max' => 100,
                    'min' => 0,
                    'id' => 'stroke-opacity'
                ]) !!}
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
            {!! Form::text('name', \App\Facades\FormCopy::field('name')->string(), ['placeholder' => __('maps/markers.placeholders.name'), 'class' => '', 'maxlength' => 191, 'id' => 'name']) !!}
        </x-forms.field>

        @include('cruds.fields.entity')

        @if (!isset($model))
            <div class="md:col-span-2">
                <x-alert type="info">
                    {{ __('maps/markers.hints.entry') }}
                </x-alert>
            </div>
        @else
        <div class="md:col-span-2" style="{{ ($model->hasEntry() ? 'display: none' : '') }}">
            <a href="#" class="map-marker-entry-click">{{ __('maps/markers.actions.entry') }}</a>
        </div>
        <div class="md:col-span-2 map-marker-entry-entry" style="{{ (!$model->hasEntry() ? 'display: none' : '') }}">
            <x-forms.field field="entry" :label=" __('crud.fields.entry')">
                {!! Form::textarea(
                    'entry',
                    \App\Facades\FormCopy::field('entry')->string(),
                    ['class' => ' html-editor', 'id' => 'marker-entry', 'name' => 'entry']
                ) !!}
            </x-forms.field>
        </div>
        @endif

        @include('maps.markers.fields.opacity')

        <div class="" id="map-marker-bg-colour" @if((isset($model) && $model->isLabel()) || (isset($source) && $source->isLabel())) style="display: none;"@endif>
            @include('maps.markers.fields.background_colour')
        </div>

        <x-forms.field field="group" :label="__('maps/markers.fields.group')">
            {{ Form::select('group_id', $map->groupOptions(), \App\Facades\FormCopy::field('group_id')->string(), ['class' => '', 'id' => 'group_id']) }}
        </x-forms.field>

        <x-forms.field field="is_popupless" :label="__('maps/markers.fields.popupless')">
            <input type="hidden" name="is_popupless" value="0" />
            <x-checkbox :text="__('maps/markers.helpers.is_popupless')">
                {!! Form::checkbox('is_popupless', 1, FormCopy::field('is_popupless')->string()) !!}
            </x-checkbox>
        </x-forms.field>

        @include('cruds.fields.visibility_id')

    </x-grid>

    <x-grid :hidden="!$model && empty($source)">
        <x-forms.field field="latitude" :label="__('maps/markers.fields.latitude')">
            {!! Form::number('latitude', \App\Facades\FormCopy::field('latitude')->string(), ['class' => '', 'id' => 'marker-latitude', 'step' => 0.001]) !!}
        </x-forms.field>

        <x-forms.field field="longitude" :label="__('maps/markers.fields.longitude')">
            {!! Form::number('longitude', \App\Facades\FormCopy::field('longitude')->string(), ['class' => '', 'id' => 'marker-longitude', 'step' => 0.001]) !!}
        </x-forms.field>
    </x-grid>
</div>

<input type="hidden" name="shape_id" value="{{ (!isset($model) ? !empty($source) ? $source->shape_id : 1 : 0) }}" />
@if (isset($from))
    <input type="hidden" name="from" value="{{ $from }}" />
@endif
@includeWhen(isset($model), 'editors.editor')

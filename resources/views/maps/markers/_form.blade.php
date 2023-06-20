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
            <a href="#marker-pin" data-nohash="true" data-toggle="tooltip" class="text-center" title="{{ __('maps/markers.tabs.marker') }}">
                <x-icon class="fa-solid fa-2x fa-map-pin"></x-icon>
                <br />
                {{ __('maps/markers.tabs.marker') }}
            </a>
        </li>
        <li role="presentation" @if($activeTab == 2) class="active" @endif>
            <a href="#marker-label" data-nohash="true"  data-toggle="tooltip" class="text-center" title="{{ __('maps/markers.tabs.label') }}">
                <x-icon class="fa-solid fa-2x fa-font"></x-icon>
                <br />
                {{ __('maps/markers.tabs.label') }}
            </a>
        </li>
        <li role="presentation" @if($activeTab == 3) class="active" @endif>
            <a href="#marker-circle" data-nohash="true"  data-toggle="tooltip" class="text-center" title="{{ __('maps/markers.tabs.circle') }}">
                <x-icon class="fa-regular fa-2x fa-circle"></x-icon>
                <br />
                {{ __('maps/markers.tabs.circle') }}
            </a>
        </li>
        <li role="presentation" @if($activeTab == 5) class="active" @endif>
            <a href="#marker-poly" data-nohash="true"  data-toggle="tooltip" class="text-center" title="{{ __('maps/markers.tabs.polygon') }}">
                <x-icon class="fa-solid fa-2x fa-draw-polygon"></x-icon>
                <br />
                {{ __('maps/markers.tabs.polygon') }}
            </a>
        </li>
        <li role="presentation">
            <a href="#presets" data-nohash="true" class="text-center" data-presets="{{ route('preset_types.presets.index', ['preset_type' => \App\Models\PresetType::MARKER, 'from' => $from ?? null]) }}">
                <x-icon class="fa-solid fa-2x fa-wand-magic-sparkles"></x-icon>
                <br />
                {{ __('maps/markers.tabs.preset') }}
            </a>
        </li>
    </ul>

    <div class="tab-content bg-base-100 shadow-sm rounded mb-5 p-4 rounded-bl rounded-br">
        <div class="tab-pane @if($activeTab == 1) active @endif" id="marker-pin">
            <x-grid>
                @include('maps.markers.fields.icon')
                @include('maps.markers.fields.custom_icon')

                @include('maps.markers.fields.pin_size')
                @include('maps.markers.fields.font_colour')

                <div class="field-draggable checkbox col-span-2">
                    {!! Form::hidden('is_draggable', 0) !!}
                    <label>{!! Form::checkbox('is_draggable', 1, (!empty($source) ? $source->is_draggable : null)) !!}
                        {{ __('maps/markers.fields.is_draggable') }}
                    </label>
                    <p class="help-block m-0">{{ __('maps/markers.helpers.draggable') }}</p>
                </div>
            </x-grid>
        </div>
        <div class="tab-pane @if($activeTab == 2) active @endif" id="marker-label">
            <p class="help-block">{{ __('maps/markers.helpers.label') }}</p>
        </div>
        <div class="tab-pane @if($activeTab == 3) active @endif" id="marker-circle">
            <x-grid>
                <div class="field-size">
                    <label for="size_id">{{ __('maps/markers.fields.size') }}</label>
                    {!! Form::select('size_id', $sizeOptions, \App\Facades\FormCopy::field('size_id')->string(), ['class' => 'form-control', 'id' => 'size_id']) !!}
                </div>
                <div class="field-radius">
                    <label for="circle_radius">{{ __('maps/markers.fields.circle_radius') }}</label>
                    {!! Form::text('circle_radius', \App\Facades\FormCopy::field('circle_radius')->string(), ['class' => 'form-control map-marker-circle-radius', 'id' => 'circle_radius', 'style' => (!isset($model) || $model->shape_id != 6) ? 'display:none;' : '']) !!}
                    <p class="help-block map-marker-circle-helper">{{ __('maps/markers.helpers.custom_radius') }}</p>
                </div>
            </x-grid>
        </div>
        <div class="tab-pane @if($activeTab == 5) active @endif" id="marker-poly">

            <x-grid>
                <div class="field-shape col-span-2">
                    <div class="flex">
                        <div class="grow">
                            <label>{{ __('maps/markers.fields.custom_shape') }}</label>
                            @if ($campaignService->campaign()->boosted())
                                @if(isset($model))
                                    <p class="help-block mb-0">
                                        {{ __('maps/markers.helpers.polygon.edit') }}
                                    </p>
                                </div>

                                <a href="#" id="reset-polygon" class="btn2 btn-error btn-outline pull-right btn-sm mb-1" style="">
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
                        <a href="#" id="reset-polygon" class="btn2 btn-error btn-outline btn-sm pull-right" style="display: none">
                            <x-icon class="fa-solid fa-eraser"></x-icon>
                            {{ __('maps/markers.actions.reset-polygon') }}
                        </a>
                    </div>
                    @endif
                        {!! Form::textarea('custom_shape', \App\Facades\FormCopy::field('custom_shape')->string(), ['class' => 'form-control', 'rows' => 2, 'placeholder' => __('maps/markers.placeholders.custom_shape')]) !!}
                    @else
                        <x-cta :campaign="$campaignService->campaign()" image="0">
                            <p>{{ __('maps/markers.pitches.poly') }}</p>
                        </x-cta>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="field-stroke">
                    <label>{{ __('maps/markers.fields.polygon_style.stroke') }}</label><br />
                    {!! Form::text('polygon_style[stroke]', \App\Facades\FormCopy::field('polygon_style[stroke]')->string(), ['class' => 'form-control spectrum']) !!}
                </div>

                <div class="field-width">
                    <label for="stroke-width">{{ __('maps/markers.fields.polygon_style.stroke-width') }}</label>
                    {!! Form::number('polygon_style[stroke-width]', \App\Facades\FormCopy::field('polygon_style[stroke-width]')->string(), ['class' => 'form-control', 'maxlength' => 2, 'step' => 1, 'max' => 99, 'min' => 0, 'id' => 'stroke-width']) !!}
                </div>

                <div class="field-opacity">
                    <label for="stroke-opacity">{{ __('maps/markers.fields.polygon_style.stroke-opacity') }}</label>
                    {!! Form::number('polygon_style[stroke-opacity]', \App\Facades\FormCopy::field('polygon_style[stroke-opacity]')->string(), [
                    'class' => 'form-control',
                    'maxlength' => 3,
                    'step' => 10,
                    'max' => 100,
                    'min' => 0,
                    'id' => 'stroke-opacity'
                ]) !!}
                </div>
            </x-grid>
        </div>

        <div class="tab-pane pane-presets" id="presets">
            <p class="help-block mb-0">
                {!! __('maps/markers.presets.helper') !!}
            </p>

            <div class="marker-preset-list rounded">
                <div class="text-center">
                    <i class="fa-solid fa-spin fa-spinner"></i>
                </div>
            </div>

            @can('mapPresets', $campaignService->campaign())
                <a href="{{ route('preset_types.presets.create', ['preset_type' => \App\Models\PresetType::MARKER, 'from' => $from ?? null]) }}" class="btn2 btn-primary btn-sm">
                    {{ __('presets.actions.create') }}
                </a>
            @endcan
        </div>
    </div>
</div>

<div id="marker-main-fields">
    <x-grid>
        <div class="field-name">
            <label for="name">{{ __('crud.fields.name') }}</label>
            {!! Form::text('name', \App\Facades\FormCopy::field('name')->string(), ['placeholder' => __('maps/markers.placeholders.name'), 'class' => 'form-control', 'maxlength' => 191, 'id' => 'name']) !!}
        </div>

        @include('cruds.fields.entity')

        <div class="col-span-2" style="{{ (isset($model) && $model->hasEntry() ? 'display: none' : '') }}">
            <a href="#" class="map-marker-entry-click">{{ __('maps/markers.actions.entry') }}</a>
        </div>
        <div class="col-span-2 map-marker-entry-entry" style="{{ (!isset($model) || !$model->hasEntry() ? 'display: none' : '') }}">
            <div class="field-entry">
                <label>{{ __('crud.fields.entry') }}</label>
                {!! Form::textarea('entry', \App\Facades\FormCopy::field('entry')->string(), ['class' => 'form-control html-editor', 'id' => 'marker-entry', 'name' => 'entry']) !!}
            </div>
        </div>

        @include('maps.markers.fields.opacity')

        <div class="" id="map-marker-bg-colour" @if((isset($model) && $model->isLabel()) || (isset($source) && $source->isLabel())) style="display: none;"@endif>
            @include('maps.markers.fields.background_colour')
        </div>

        <div class="field-group">
            <label for="group_id">
                {{ __('maps/markers.fields.group') }}
            </label>
            {{ Form::select('group_id', $map->groupOptions(), \App\Facades\FormCopy::field('group_id')->string(), ['class' => 'form-control', 'id' => 'group_id']) }}
        </div>

        @include('cruds.fields.visibility_id')
    </x-grid>

    <x-grid :hidden="!$model && empty($source)">
        <div class="field-latitude">
            <label>{{ __('maps/markers.fields.latitude') }}</label>
            {!! Form::number('latitude', \App\Facades\FormCopy::field('latitude')->string(), ['class' => 'form-control', 'id' => 'marker-latitude', 'step' => 0.001]) !!}
        </div>

        <div class="field-longitude">
            <label>{{ __('maps/markers.fields.longitude') }}</label>
            {!! Form::number('longitude', \App\Facades\FormCopy::field('longitude')->string(), ['class' => 'form-control', 'id' => 'marker-longitude', 'step' => 0.001]) !!}
        </div>
    </x-grid>
</div>

{!! Form::hidden('shape_id', (!isset($model) ? !empty($source) ? $source->shape_id : 1 : null)) !!}

@include('editors.editor')

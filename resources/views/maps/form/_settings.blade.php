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
<div class="row">
    <div class="col-sm-6">
        <input type="hidden" name="is_real" value="0" />
        <div class="form-group checkbox">
            <label>
                {!! Form::checkbox('is_real') !!}
                {{ __('maps.fields.is_real') }}
            </label>
            <p class="help-block">
                {!! __('maps.helpers.is_real') !!}
            </p>
        </div>
    </div>
    <div class="col-sm-6">

        <input type="hidden" name="has_clustering" value="0" />
        <div class="form-group checkbox">
            <label>
                {!! Form::checkbox('has_clustering', 1, !isset($model) ? true : $model->has_clustering) !!}
                {{ __('maps.fields.has_clustering') }}
            </label>
            <p class="help-block">
                {!! __('maps.helpers.has_clustering') !!}
            </p>
        </div>
    </div>
</div>

<hr />

@if (isset($model) && $model->isChunked())
    <div class="alert alert-info">
        <p>{{ __('maps.helpers.chunked_zoom') }}</p>
    </div>
@else
<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label>{{ __('maps.fields.max_zoom') }}</label>
            {!! Form::number(
            'max_zoom',
            FormCopy::field('max_zoom')->string(),
            [
            'placeholder' => 5,
            'class' => 'form-control',
            'min' => 0,
            'max' => Map::MAX_ZOOM,
            ]
            ) !!}
            <p class="help-block">
                {{ __('maps.helpers.max_zoom', ['max' => Map::MAX_ZOOM, 'default' => 5]) }}</p>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label>{{ __('maps.fields.min_zoom') }}</label>
            {!! Form::number(
            'min_zoom',
            FormCopy::field('min_zoom')->string(),
            [
            'placeholder' => -2,
            'class' => 'form-control',
            'min' => Map::MIN_ZOOM,
            'max' => Map::MAX_ZOOM_REAL,
            ]
            ) !!}
            <p class="help-block">
                {{ __('maps.helpers.min_zoom', ['min' => Map::MIN_ZOOM, 'default' => -2]) }}</p>
        </div>
    </div>
</div>
@endif
<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label>{{ __('maps.fields.initial_zoom') }}</label>
            {!! Form::number(
            'initial_zoom',
            FormCopy::field('initial_zoom')->string(),
            [
            'placeholder' => 5,
            'class' => 'form-control',
            'min' => $minInitial,
            'max' => $maxInitial,
            ]
            ) !!}
            <p class="help-block">
                {{ __('maps.helpers.initial_zoom', ['min' => $minInitial, 'max' => $maxInitial, 'default' => $defaultInitial]) }}
            </p>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label>{{ __('maps.fields.grid') }}</label>
            {!! Form::number(
            'grid',
            FormCopy::field('grid')->string(),
            [
            'placeholder' => __('maps.placeholders.grid'),
            'class' => 'form-control',
            'maxlength' => 4
            ]
            ) !!}
            <p class="help-block">{{ __('maps.helpers.grid') }}</p>
        </div>
    </div>
</div>

<hr />


<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label>{{ __('maps.fields.distance_name') }}</label>
            {!! Form::text(
                'config[distance_name]',
                FormCopy::field('config[distance_name]')->string(),
                [
                    'placeholder' => __('maps.placeholders.distance_name'),
                    'class' => 'form-control',
                    'maxlength' => 20
                ]
                ) !!}
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label>
                {{ __('maps.fields.distance_measure') }}
                <i class="fa-solid fa-question-circle hidden-xs hidden-sm" data-toggle="tooltip" title="{{ __('maps.helpers.distance_measure') . ' ' . __('maps.helpers.distance_measure_2')}}"></i>
            </label>
            {!! Form::number(
            'config[distance_measure]',
            FormCopy::field('config[distance_measure]')->string(),
            [
                'class' => 'form-control',
                'min' => 0.0001,
                'max' => 100.99,
                'step' => 0.0001,
            ]
            ) !!}
            <p class="help-block visible-xs visible-sm">{{ __('maps.helpers.distance_measure') . ' ' . __('maps.helpers.distance_measure_2') }}</p>
        </div>
    </div>
</div>

<hr />

<div class="row">
    <div class="col-sm-12 nav-tabs-custom" style="box-shadow: none">
        <div class="form-group">
            <label>{{ __('maps.fields.centering') }}</label>
            <p class="help-block">
                {{ __('maps.helpers.centering') }}
            </p>
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#coordinates">{{ __('maps.fields.tabs.coordinates') }}</a>
                </li>
                <li class="{{ (isset($model) && !empty($model))? '' : 'disabled disabledLink' }}">
                    <a class="{{ (isset($model) && !empty($model))? '' : 'disabledTab' }}" data-toggle="tab"
                        href="#marker">{{ __('maps.fields.tabs.marker') }}</a>
                </li>
            </ul>

            <div class="tab-content">
                <div id="coordinates" class="tab-pane fade in active p-2">
                    <div class="col-sm-12">
                        <p class="help-block">
                            {{ __('maps.helpers.center') }}
                        </p>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>{{ __('maps.fields.center_y') }}</label>
                            {!! Form::number(
                            'center_y',
                            FormCopy::field('center_y')->string(),
                            [
                            'placeholder' => __('maps.placeholders.center_y'),
                            'class' => 'form-control',
                            'min' => -90,
                            'step' => 0.001
                            ]
                            ) !!}
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>{{ __('maps.fields.center_x') }}</label>
                            {!! Form::number(
                            'center_x',
                            FormCopy::field('center_x')->string(),
                            [
                            'placeholder' => __('maps.placeholders.center_x'),
                            'class' => 'form-control',
                            'min' => -180,
                            'step' => 0.001
                            ]
                            ) !!}
                        </div>
                    </div>
                </div>
                <div id="marker" class="tab-pane fade">
                    <div class="col-sm-12">
                        @if (isset($model) && !empty($model))
                        <?php
                            //get the current center marker or null
                            $preset = null;
                            if (isset($model) && $model->center_marker) {
                                $preset = $model->center_marker;
                            }
                        ?>

                        {!! Form::foreignSelect(
                        'center_marker_id',
                        [
                        'preset' => $preset,
                        'class' => App\Models\MapMarker::class,
                        'labelKey' => 'maps.fields.center_marker',
                        'placeholderKey' => 'maps.placeholders.center_marker',
                        'searchRouteName' => 'markers.find',
                        'searchParams' => [
                        'include' => $model->id
                        ]
                        ]
                        ) !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

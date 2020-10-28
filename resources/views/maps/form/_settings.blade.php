{{--<div class="row">--}}
{{--    <div class="col-sm-6">--}}

{{--        <div class="form-group">--}}
{{--            <label>{{ trans('maps.fields.distance_name') }}</label>--}}
{{--            {!! Form::text(--}}
{{--                'distance_name',--}}
{{--                FormCopy::field('distance_name')->string(),--}}
{{--                [--}}
{{--                    'placeholder' => trans('maps.placeholders.distance_name'),--}}
{{--                    'class' => 'form-control',--}}
{{--                    'maxlength' => 20--}}
{{--                ]--}}
{{--            ) !!}--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="col-sm-6">--}}

{{--        <label>{{ trans('maps.fields.distance_measure') }}</label>--}}
{{--        {!! Form::number(--}}
{{--            'distance_measure',--}}
{{--            FormCopy::field('distance_measure')->string(),--}}
{{--            [--}}
{{--                'placeholder' => trans('maps.placeholders.distance_measure'),--}}
{{--                'class' => 'form-control',--}}
{{--                'maxlength' => 4--}}
{{--            ]--}}
{{--        ) !!}--}}
{{--    </div>--}}
{{--</div>--}}
{{--<p class="help-block">{{ __('maps.helpers.distance_measure') }}</p>--}}

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label>{{ trans('maps.fields.initial_zoom') }}</label>
            {!! Form::number(
                'initial_zoom',
                FormCopy::field('initial_zoom')->string(),
                [
                    'placeholder' => 0,
                    'class' => 'form-control',
                    'min' => \App\Models\Map::MIN_ZOOM,
                    'max' => \App\Models\Map::MAX_ZOOM,
                ]
            ) !!}
            <p class="help-block">{{ __('maps.helpers.initial_zoom', ['min' => \App\Models\Map::MIN_ZOOM, 'max' => \App\Models\Map::MAX_ZOOM, 'default' => 0]) }}</p>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label>{{ trans('maps.fields.min_zoom') }}</label>
            {!! Form::number(
                'min_zoom',
                FormCopy::field('min_zoom')->string(),
                [
                    'placeholder' => -2,
                    'class' => 'form-control',
                    'min' => \App\Models\Map::MIN_ZOOM,
                    'max' => 0,
                ]
            ) !!}
            <p class="help-block">{{ __('maps.helpers.min_zoom', ['min' => \App\Models\Map::MIN_ZOOM, 'default' => -2]) }}</p>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label>{{ trans('maps.fields.max_zoom') }}</label>
            {!! Form::number(
                'max_zoom',
                FormCopy::field('max_zoom')->string(),
                [
                    'placeholder' => 5,
                    'class' => 'form-control',
                    'min' => 0,
                    'max' => \App\Models\Map::MAX_ZOOM,
                ]
            ) !!}
            <p class="help-block">{{ __('maps.helpers.max_zoom', ['max' => \App\Models\Map::MAX_ZOOM, 'default' => 5]) }}</p>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label>{{ trans('maps.fields.grid') }}</label>
            {!! Form::number(
                'grid',
                FormCopy::field('grid')->string(),
                [
                    'placeholder' => trans('maps.placeholders.grid'),
                    'class' => 'form-control',
                    'maxlength' => 4
                ]
            ) !!}
            <p class="help-block">{{ __('maps.helpers.grid') }}</p>
        </div>
    </div>
</div>

<hr />

<p class="help-block">
    {{ __('maps.helpers.center') }}
</p>
<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label>{{ trans('maps.fields.center_x') }}</label>
            {!! Form::number(
                'center_x',
                FormCopy::field('center_x')->string(),
                [
                    'placeholder' => __('maps.placeholders.center_x'),
                    'class' => 'form-control',
                    'min' => 0,
                ]
            ) !!}
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label>{{ trans('maps.fields.center_y') }}</label>
            {!! Form::number(
                'center_y',
                FormCopy::field('center_y')->string(),
                [
                    'placeholder' => __('maps.placeholders.center_y'),
                    'class' => 'form-control',
                    'min' => 0,
                ]
            ) !!}
        </div>
    </div>
</div>


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


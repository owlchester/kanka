<?php /** @var \App\Models\Calendar $model */ ?>
<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.name', ['trans' => 'calendars'])
    </div>
    <div class="col-md-6">
        @include('cruds.fields.type', ['base' => \App\Models\Calendar::class, 'trans' => 'calendars'])
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>{{ __('calendars.fields.current_year') }}</label>
                    {!! Form::number('current_year', !empty($model) ? $model->currentDate('year') : (isset($source) ? $source->currentDate('year') : null), ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-md-4">

                <div class="form-group">
                    <label>{{ __('calendars.fields.current_month') }}</label>
                    {!! Form::number('current_month', !empty($model) ? $model->currentDate('month') : (isset($source) ? $source->currentDate('month') : null), ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-md-4">

                <div class="form-group">
                    <label>{{ __('calendars.fields.current_day') }}</label>
                    {!! Form::number('current_day', !empty($model) ? $model->currentDate('date') : (isset($source) ? $source->currentDate('date') : null), ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ __('calendars.fields.suffix') }}</label>
            {!! Form::text('suffix', FormCopy::field('suffix')->string(), ['placeholder' => __('calendars.placeholders.suffix'), 'class' => 'form-control', 'maxlength' => 191]) !!}
        </div>
    </div>
</div>

@include('cruds.fields.entry2')

<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.tags')
    </div>
    <div class="col-md-6">
        @include('cruds.fields.image')
    </div>
</div>

@include('cruds.fields.private2')

@if (request()->has('redirect'))
    {!! Form::hidden('redirect', request()->get('redirect')) !!}
@endif

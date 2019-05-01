<?php /** @var \App\Models\Calendar $model */ ?>
<div class="row">
    <div class="col-md-6">
        <div class="form-group required">
            <label>{{ trans('calendars.fields.name') }}</label>
            {!! Form::text('name', $formService->prefill('name', $source), ['placeholder' => trans('calendars.placeholders.name'), 'class' => 'form-control', 'maxlength' => 191]) !!}
        </div>
        @include('cruds.fields.type', ['base' => \App\Models\Calendar::class, 'trans' => 'calendars'])
        <div class="form-group">
            <label>{{ trans('calendars.fields.suffix') }}</label>
            {!! Form::text('suffix', $formService->prefill('suffix', $source), ['placeholder' => trans('calendars.placeholders.suffix'), 'class' => 'form-control', 'maxlength' => 191]) !!}
        </div>
        @include('cruds.fields.tags')
        @include('cruds.fields.attribute_template')

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>{{ trans('calendars.fields.current_year') }}</label>
                    {!! Form::number('current_year', !empty($model) ? $model->currentDate('year') : null, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-md-4">

                <div class="form-group">
                    <label>{{ trans('calendars.fields.current_month') }}</label>
                    {!! Form::number('current_month', !empty($model) ? $model->currentDate('month') : null, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-md-4">

                <div class="form-group">
                    <label>{{ trans('calendars.fields.current_day') }}</label>
                    {!! Form::number('current_day', !empty($model) ? $model->currentDate('date') : null, ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>

        @include('cruds.fields.private')
    </div>
    <div class="col-md-6">
        @include('cruds.fields.entry2')
        @include('cruds.fields.image')
    </div>
</div>
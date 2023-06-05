<?php /** @var \App\Models\Calendar $model */ ?>
<x-grid>
    @include('cruds.fields.name', ['trans' => 'calendars'])

    @include('cruds.fields.type', ['base' => \App\Models\Calendar::class, 'trans' => 'calendars'])

    <div class="current grid grid-cols-3 gap-2">
        <div class="form-group">
            <label>{{ __('calendars.fields.current_year') }}</label>
            {!! Form::number('current_year', !empty($model) ? $model->currentDate('year') : (isset($source) ? $source->currentDate('year') : null), ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            <label>{{ __('calendars.fields.current_month') }}</label>
            {!! Form::number('current_month', !empty($model) ? $model->currentDate('month') : (isset($source) ? $source->currentDate('month') : null), ['class' => 'form-control', 'min' => 1]) !!}
        </div>

        <div class="form-group">
            <label>{{ __('calendars.fields.current_day') }}</label>
            {!! Form::number('current_day', !empty($model) ? $model->currentDate('date') : (isset($source) ? $source->currentDate('date') : null), ['class' => 'form-control', 'min' => 1]) !!}
        </div>
    </div>

    <div class="form-group suffix">
        <label>{{ __('calendars.fields.suffix') }}</label>
        {!! Form::text('suffix', FormCopy::field('suffix')->string(), ['placeholder' => __('calendars.placeholders.suffix'), 'class' => 'form-control', 'maxlength' => 45]) !!}
    </div>

    @include('cruds.fields.entry2')

    @include('cruds.fields.tags')

    @include('cruds.fields.image')
</x-grid>

@if (request()->has('redirect'))
    {!! Form::hidden('redirect', request()->get('redirect')) !!}
@endif

@section('scripts')
    @parent
    @vite('resources/js/forms/calendar.js')
@endsection

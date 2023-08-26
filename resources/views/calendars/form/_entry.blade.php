<?php /** @var \App\Models\Calendar $model */ ?>
<x-grid>
    @include('cruds.fields.name', ['trans' => 'calendars'])

    @include('cruds.fields.type', ['base' => \App\Models\Calendar::class, 'trans' => 'calendars'])

    <div class="current grid grid-cols-3 gap-2">

        <x-forms.field
            field="year"
            :label="__('calendars.fields.current_year')">
            {!! Form::number('current_year', !empty($model) ? $model->currentDate('year') : (isset($source) ? $source->currentDate('year') : null)) !!}
        </x-forms.field>
        <x-forms.field
            field="month"
            :label="__('calendars.fields.current_month')">
            {!! Form::number('current_month', !empty($model) ? $model->currentDate('month') : (isset($source) ? $source->currentDate('month') : null)) !!}
        </x-forms.field>
        <x-forms.field
            field="day"
            :label="__('calendars.fields.current_day')">
            {!! Form::number('current_day', !empty($model) ? $model->currentDate('date') : (isset($source) ? $source->currentDate('date') : null)) !!}
        </x-forms.field>

    </div>

    <x-forms.field
        field="suffix"
        :label="__('calendars.fields.suffix')">
        {!! Form::text('suffix', FormCopy::field('suffix')->string(), ['placeholder' => __('calendars.placeholders.suffix'), 'maxlength' => 45]) !!}
    </x-forms.field>

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

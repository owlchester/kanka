<?php /** @var \App\Models\Calendar $model */ ?>
<x-grid>
    @include('cruds.fields.entity-name')

    @include('cruds.fields.type', ['base' => \App\Models\Calendar::class, 'trans' => 'calendars'])

    <div class="current grid grid-cols-3 gap-2">

        <x-forms.field
            field="year"
            :label="__('calendars.fields.current_year')">

            <input type="number" name="current_year" class="w-full" value="{{ !empty($model) ? $model->currentDate('year') : (isset($source) ? $source->child->currentDate('year') : null) }}" placeholder="{{ __('calendars.fields.current_year') }}" aria-label="{{ __('calendars.fields.current_year') }}" />
        </x-forms.field>
        <x-forms.field
            field="month"
            :label="__('calendars.fields.current_month')">
            <input type="number" name="current_month" class="w-full" value="{{ !empty($model) ? $model->currentDate('month') : (isset($source) ? $source->child->currentDate('month') : null) }}" placeholder="{{ __('calendars.fields.current_month') }}" min="1" aria-label="{{ __('calendars.fields.current_month') }}" />
        </x-forms.field>
        <x-forms.field
            field="day"
            :label="__('calendars.fields.current_day')">
            <input type="number" name="current_day" class="w-full" value="{{ !empty($model) ? $model->currentDate('date') : (isset($source) ? $source->child->currentDate('date') : null) }}" placeholder="{{ __('calendars.fields.current_day') }}" min="1" aria-label="{{ __('calendars.fields.current_day') }}" />
        </x-forms.field>

    </div>

    <x-forms.field
        field="suffix"
        :label="__('calendars.fields.suffix')">
        <input type="text" name="suffix" value="{{ old('suffix', $source->child->suffix ?? $model->suffix ?? null) }}" maxlength="45" class="w-full" placeholder="{{ __('calendars.placeholders.suffix') }}" />
    </x-forms.field>

    @include('cruds.fields.entry2')

    @include('cruds.fields.tags')

    @include('cruds.fields.image')
</x-grid>

@if (request()->has('redirect'))
    <input type="hidden" name="redirect" value="{{ request()->get('redirect') }}"/>
@endif

@section('scripts')
    @parent
    @vite('resources/js/forms/calendar.js')
@endsection

<?php
/**
 * @var \App\Models\Calendar $calendar
 * @var \App\Models\CalendarEra|null $model
 * @var \App\Models\Campaign $campaign
 */
?>
<x-grid>
    <x-forms.field field="name" required :label="__('crud.fields.name')">
        <input type="text" name="name" placeholder="{{ __('calendars/eras.placeholders.name') }}" value="{{ old('name', $model->name ?? null) }}" maxlength="191" required class="w-full" />
    </x-forms.field>

    @include('cruds.fields.colour_picker', ['model' => $model ?? null])

    <x-forms.field field="description" css="col-span-2" :label="__('calendars/eras.fields.description')">
        <textarea name="description" rows="3" class="w-full">{{ old('description', $model->description ?? null) }}</textarea>
    </x-forms.field>

    <x-forms.field field="start_year" :label="__('calendars/eras.fields.start_year')">
        <input type="number" name="start_year" class="w-full" value="{{ old('start_year', $model->start_year ?? null) }}" required />
    </x-forms.field>

    <x-forms.field field="start_month" :label="__('calendars/eras.fields.start_month')">
        <input type="number" name="start_month" class="w-full" value="{{ old('start_month', $model->start_month ?? null) }}" min="1" />
    </x-forms.field>

    <x-forms.field field="start_day" :label="__('calendars/eras.fields.start_day')">
        <input type="number" name="start_day" class="w-full" value="{{ old('start_day', $model->start_day ?? null) }}" min="1" />
    </x-forms.field>

    <div></div>

    <x-forms.field field="end_year" :label="__('calendars/eras.fields.end_year')">
        <input type="number" name="end_year" class="w-full" value="{{ old('end_year', $model->end_year ?? null) }}" />
    </x-forms.field>

    <x-forms.field field="end_month" :label="__('calendars/eras.fields.end_month')">
        <input type="number" name="end_month" class="w-full" value="{{ old('end_month', $model->end_month ?? null) }}" min="1" />
    </x-forms.field>

    <x-forms.field field="end_day" :label="__('calendars/eras.fields.end_day')">
        <input type="number" name="end_day" class="w-full" value="{{ old('end_day', $model->end_day ?? null) }}" min="1" />
    </x-forms.field>

    <x-helper class="col-span-2 m-0">{{ __('calendars/eras.hints.end_date') }}</x-helper>

    <x-forms.field field="show_era_dates" css="col-span-2" :label="__('calendars/eras.fields.show_era_dates')">
        <input type="hidden" name="show_era_dates" value="0" />
        <x-checkbox :text="__('calendars/eras.hints.show_era_dates')">
            <input type="checkbox" name="show_era_dates" value="1" @if (old('show_era_dates', $model->show_era_dates ?? false)) checked="checked" @endif />
        </x-checkbox>
    </x-forms.field>

    @include('cruds.fields.visibility_id', ['model' => $model ?? null])
</x-grid>

<?php
/**
 * View used in Quest and Journals form "calendar" button
 * @var \App\Models\Journal $model
 * @var \App\Models\Post $post
 */
$calendars = \App\Models\Calendar::get();
$onlyOneCalendar = count($calendars) == 1;
$oldCalendarID = old('calendar_id');
$sourceRemidner = null;
// Make sure the user has access to the source's calendar
if (!empty($source) && empty($post) && $source->calendarReminder()) {
    $oldCalendarID = $source->calendarReminder()->calendar_id;
    $sourceReminder = $source->calendarReminder();
} elseif (!empty($post) && $post->calendarReminder()) {
    $oldCalendarID = $post->calendarReminder()->calendar_id;
    $sourceReminder = $post->calendarReminder();
}

if (!empty($post)) {
    $model = $post;
} elseif (isset($entity)) {
    $model = $entity;
}

$calendar = null;
if (!empty($oldCalendarID)) {
    $calendar = \App\Models\Calendar::find($oldCalendarID);
}
$opened = (isset($model) && $model->hasCalendar()) || !empty($oldCalendarID);
?>
@if (isset($model) && $model->hasCalendarButNoAccess())
    <input type="hidden" name="calendar_id" value="{{ $model->calendarReminder()->calendar_id }}" />
    <input type="hidden" name="calendar_skip" value="1" />
    @php return; @endphp
@endif
<div class="field-calendar-date flex flex-col gap-4" x-data="{ opened: {{ $opened ? 'true' : 'false' }} }">
    <div class="flex flex-col gap-1 items-start" >
        <label>{{ __('crud.fields.calendar_date') }}</label>
        <span role="button" id="entity-calendar-form-add" class="btn2 btn-sm btn-outline <?=(!empty($model) && $model->hasCalendar() || !empty($oldCalendarID) ? "hidden" : null)?>" data-default-calendar="{{ ($onlyOneCalendar ? $calendars->first()->id : null) }}" @click="opened = !opened" x-show="!opened">
        @php $calendarModule = \App\Models\EntityType::default()->where('code', 'calendar')->first(); @endphp
            <x-icon :class="$calendarModule->icon()" />
            {{ __('entities/reminders.actions.add') }}
        </span>

        <x-helper>
            <p class="text-xs">{{ __('entities/reminders.helpers.pitch') }}</p>
        </x-helper>
    </div>

    <div class="entity-calendar-form transition-all duration-150 flex flex-col gap-4" x-show="opened">
        @if (count($calendars) == 1)
            <input type="hidden" name="calendar_id" value="{{ isset($model) && $model->hasCalendar() ? $model->calendarReminder()->calendar_id : $source->calendar_id ?? null }}" />
        @else
            <input type="hidden" name="calendar_id" />
            <div class="grid gap-2 md:gap-4 md:grid-cols-3">
                <div class="field-calendar entity-calendar-selector">
                    <x-forms.foreign
                        :campaign="$campaign"
                        name="calendar_id"
                        key="calendar"
                        :allowClear="true"
                        :route="route('search-list', [$campaign, config('entities.ids.calendar')])"
                        :selected="isset($model) && $model->calendarReminder() && $model->calendarReminder()->calendar ? $model->calendarReminder()->calendar : FormCopy::field('calendar')->select()"
                        :dropdownParent="$dropdownParent ?? null"
                        :entityTypeID="config('entities.ids.calendar')">
                    </x-forms.foreign>
                </div>
            </div>
        @endif

        <div class="entity-calendar-subform @if (!$opened) hidden @endif">
            <div class="grid gap-2 md:gap-4 md:grid-cols-3">
                <x-forms.field
                    field="year"
                    :label="__('calendars.fields.year')">

                    <input type="number" name="calendar_year" class="w-full" value="{{ old('calendar_year', $source->calendar_year ?? $model->calendar_year ?? null) }}" />
                </x-forms.field>

                <x-forms.field
                    field="month"
                    :label="__('calendars.fields.month')">
                    <x-forms.select
                        name="calendar_month"
                        id="reminder_month"
                        :options="(!empty($model) && $model->hasCalendar() ? $model->calendarReminder()->calendar->monthList(): (!empty($calendar) ? $calendar->monthList() : []))"
                        :selected="$source->calendar_month ?? $model->calendar_month ?? null"
                        :optionAttributes="(!empty($model) && $model->hasCalendar() ? $model->calendarReminder()->calendar->monthDataProperties(): (!empty($calendar) ? $calendar->monthDataProperties() : []))" />
                </x-forms.field>

                <x-forms.field
                    field="day"
                    :label="__('calendars.fields.day')">
                    <x-forms.select
                        name="calendar_day"
                        id="reminder_day"
                        :options="(!empty($model) && $model->hasCalendar() ? $model->calendarReminder()->calendar->dayList($model->calendarReminder()->month) : (!empty($calendar) ? $calendar->dayList() : []))"
                        :selected="$source->calendar_day ?? $model->calendar_day ?? null"
                    />
                </x-forms.field>

                <x-forms.field
                    field="length"
                    :label="__('calendars.fields.length')">
                    <input type="number" name="calendar_length" id="reminder_length" class="w-full" value="{{ FormCopy::field('calendar_length')->string() ?: old('calendar_length', $source->calendar_length ?? $model->calendar_length ?? null) }}" />
                </x-forms.field>

                <x-forms.field
                    field="colour"
                    :label="__('crud.fields.colour')">
                    <span>
                        <input type="text" name="calendar_colour" value="{{ old('calendar_colour', $source->calendar_colour ?? $model->calendar_colour ?? null) }}" maxlength="7" class="spectrum" />
                    </span>
                </x-forms.field>

                <x-forms.field
                    field="periodicity"
                    :label="__('calendars.fields.is_recurring')">
                    <x-forms.select
                        name="calendar_recurring_periodicity"
                        :options="(!empty($model) && $model->hasCalendar() ? $model->calendarReminder()->calendar->recurringOptions(): (!empty($calendar) ? $calendar->recurringOptions() : []))"
                        :selected="$source->calendar_recurring_periodicity ?? $model->calendar_recurring_periodicity ?? null"
                        class="reminder-periodicity"
                        />
                </x-forms.field>
            </div>
        </div>
        <div class="entity-calendar-loading text-center p-4 hidden">
            <x-icon class="load" />
        </div>


        <div class="text-right">
            <a href="#" id="entity-calendar-form-cancel" class="btn2 btn-outline btn-error btn-sm @if ((((isset($model) && $model->hasCalendar()) || empty($model))) && $onlyOneCalendar) @else hidden @endif" @click="opened = false">
                <x-icon class="fa-regular fa-eraser" />
                {{ __('entities/reminders.actions.remove') }}
            </a>
        </div>
    </div>
</div>

<input type="hidden" name="calendar-data-url" data-url="{{ route('calendars.month-list', [$campaign, 'calendar' => 0]) }}">

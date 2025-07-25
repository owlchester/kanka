<?php
$onlyOneCalendar = count($calendars) == 1;
?>
<x-grid type="1/1">
    @empty($model)
        <x-helper>
            <p>{{ __('entities/events.create.helper', ['name' => $entity->name]) }}</p>
        </x-helper>
    @endif

    <div id="entity-calendar-modal-form w-full">
        <div class="field-calendar entOrity-calendar-selector w-full">
            <x-forms.foreign
                :campaign="$campaign"
                name="calendar_id"
                key="calendar"
                :allowNew="false"
                :allowClear="true"
                :route="route('search-list', [$campaign, config('entities.ids.calendar')] + (isset($model) ? ['exclude' => $model->id] : []))"
                :selected="$onlyOneCalendar ? $calendars->first() : null"
                :dropdownParent="$dropdownParent ?? (request()->ajax() ? '#primary-dialog' : null)"
                :entityTypeID="config('entities.ids.calendar')">
            </x-forms.foreign>
        </div>
    </div>


    <x-grid type="1/1" class="entity-calendar-subform {{ $onlyOneCalendar ? '' : 'hidden' }}">
        @include('calendars.reminders._subform')
    </x-grid>

</x-grid>

<div class="entity-calendar-loading hidden">
    <p class="text-center">
        <x-icon class="load" />
    </p>
</div>

<input type="hidden" name="calendar-data-url" data-url="{{ route('calendars.month-list', [$campaign, 'calendar' => 0]) }}">

<?php
$onlyOneCalendar = count($calendars) == 1;
?>
{{ csrf_field() }}
<x-grid type="1/1">
    <div id="entity-calendar-modal-form w-full">
        <div class="field-calendar entity-calendar-selector w-full">
            <x-forms.foreign
                :campaign="$campaign"
                name="calendar_id"
                key="calendar"
                :allowNew="false"
                :allowClear="true"
                :route="route('calendars.find', [$campaign] + (isset($model) ? ['exclude' => $model->id] : []))"
                :selected="$onlyOneCalendar ? $calendars->first() : null"
                :dropdownParent="$dropdownParent ?? (request()->ajax() ? '#primary-dialog' : null)"
                :entityTypeID="config('entities.ids.calendar')">
            </x-forms.foreign>
        </div>
    </div>
</x-grid>


<div class="entity-calendar-subform" style="{{ $onlyOneCalendar ? '' : 'display: none' }}">
    @include('calendars.events._subform')
</div>

<div class="entity-calendar-loading" style="display: none">
    <p class="text-center">
        <x-icon class="load" />
    </p>
</div>

<input type="hidden" name="calendar-data-url" data-url="{{ route('calendars.month-list', [$campaign, 'calendar' => 0]) }}">

<?php
$calendars = \App\Models\Calendar::get();
$onlyOneCalendar = count($calendars) == 1;
?>
{{ csrf_field() }}

<div id="entity-calendar-modal-form">
    <h1>waaa</h1>
    <div class="form-group entity-calendar-selector">
        <x-forms.foreign
            name="calendar_id"
            key="calendar"
            :allowNew="false"
            :allowClear="true"
            :route="route('calendars.find', isset($model) ? ['exclude' => $model->id] : null)"
            :selected="$onlyOneCalendar ? $calendars->first() : null"
            :dropdownParent="request()->ajax() ? '#entity-modal' : null">
        </x-forms.foreign>
    </div>
</div>


<div class="entity-calendar-subform" style="{{ $onlyOneCalendar ? '' : 'display: none;' }}">
    @include('calendars.events._subform', ['colourAppendTo' => '#entity-modal'])
</div>

<div class="entity-calendar-loading" style="display: none">
    <p class="text-center">
        <i class="fa-solid fa-spin fa-spinner"></i>
    </p>
</div>

<input type="hidden" name="calendar-data-url" data-url="{{ route('calendars.month-list', ['calendar' => 0]) }}">

<?php
$calendars = \App\Models\Calendar::get();
$onlyOneCalendar = count($calendars) == 1;
?>
{{ csrf_field() }}

<div id="entity-calendar-modal-form">
    <div class="form-group">
        <div class="form-group entity-calendar-selector">
            {!! Form::select2(
                'calendar_id',
                ($onlyOneCalendar ? $calendars->first() : null),
                App\Models\Calendar::class,
                false
            ) !!}
        </div>
    </div>
</div>


<div class="entity-calendar-subform" style="{{ $onlyOneCalendar ? '' : 'display: none;' }}">
    @include('calendars.events._subform')
</div>

<div class="entity-calendar-loading" style="display: none">
    <p class="text-center">
        <i class="fa fa-spin fa-spinner"></i>
    </p>
</div>

<input type="hidden" name="calendar-data-url" data-url="{{ route('calendars.month-list', ['calendar' => 0]) }}">
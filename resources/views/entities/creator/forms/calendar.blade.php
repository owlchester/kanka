
<div class="grid grid-cols-2 gap-5">
    @include('cruds.fields.type', ['base' => \App\Models\Calendar::class, 'trans' => 'calendars'])

    <div class="form-group">
        {!! Form::select2(
            'calendar_id',
            null,
            App\Models\Calendar::class,
            false,
            'calendars.fields.calendar',
            null,
            null,
            null,
            request()->ajax() ? '#entity-modal' : null,
        ) !!}
    </div>
</div>

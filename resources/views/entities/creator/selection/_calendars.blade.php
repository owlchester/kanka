<div class="option flex gap-2">

    @include('entities.creator.selection._main', [
        'singular' => 'calendar',
        'plural' => 'calendars',
        'id' => config('entities.ids.calendar'),
    ])
    @include('entities.creator.selection._full', ['key' => 'calendars'])
</div>

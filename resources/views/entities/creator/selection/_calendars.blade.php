<div class="option flex">

    @include('entities.creator.selection._main', [
        'singular' => 'calendar',
        'plural' => 'calendars',
        'icon' => config('entities.icons.calendar'),
        'id' => config('entities.ids.calendar'),
    ])
    @include('entities.creator.selection._full', ['key' => 'calendars'])
</div>

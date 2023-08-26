<div class="option flex">

    @include('entities.creator.selection._main', [
        'singular' => 'event',
        'plural' => 'events',
        'id' => config('entities.ids.event'),
    ])
    @include('entities.creator.selection._full', ['key' => 'events'])
</div>

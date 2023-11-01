<div class="option flex gap-2">

    @include('entities.creator.selection._main', [
        'singular' => 'map',
        'plural' => 'maps',
        'id' => config('entities.ids.map'),
    ])
    @include('entities.creator.selection._full', ['key' => 'maps'])
</div>

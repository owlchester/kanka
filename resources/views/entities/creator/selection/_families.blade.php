<div class="option flex gap-2">

    @include('entities.creator.selection._main', [
        'singular' => 'family',
        'plural' => 'families',
        'id' => config('entities.ids.family'),
    ])

    @include('entities.creator.selection._full', ['key' => 'families'])
</div>

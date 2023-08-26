<div class="option flex">

    @include('entities.creator.selection._main', [
        'singular' => 'family',
        'plural' => 'families',
        'icon' => config('entities.icons.family'),
        'id' => config('entities.ids.family'),
    ])

    @include('entities.creator.selection._full', ['key' => 'families'])
</div>

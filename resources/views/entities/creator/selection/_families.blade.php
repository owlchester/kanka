<div class="option flex">

    @include('entities.creator.selection._main', [
        'singular' => 'family',
        'plural' => 'families',
        'icon' => 'ra ra-double-team',
        'id' => config('entities.ids.family'),
    ])

    @include('entities.creator.selection._full', ['key' => 'families'])
</div>

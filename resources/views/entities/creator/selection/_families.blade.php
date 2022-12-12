<div class="option flex">

    @include('entities.creator.selection._main', [
        'singular' => 'family',
        'plural' => 'families',
        'icon' => 'ra ra-double-team'
    ])

    @include('entities.creator.selection._full', ['key' => 'families'])
</div>

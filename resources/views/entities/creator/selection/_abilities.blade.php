<div class="option flex">

    @include('entities.creator.selection._main', [
        'singular' => 'ability',
        'plural' => 'abilities',
        'icon' => 'ra ra-fire-symbol',
        'id' => config('entities.ids.ability'),
    ])
    @include('entities.creator.selection._full', ['key' => 'abilities'])
</div>

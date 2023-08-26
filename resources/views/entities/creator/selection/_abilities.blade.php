<div class="option flex">

    @include('entities.creator.selection._main', [
        'singular' => 'ability',
        'plural' => 'abilities',
        'icon' => config('entities.icons.ability'),
        'id' => config('entities.ids.ability'),
    ])
    @include('entities.creator.selection._full', ['key' => 'abilities'])
</div>

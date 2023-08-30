<div class="option flex gap-2">

    @include('entities.creator.selection._main', [
        'singular' => 'ability',
        'plural' => 'abilities',
        'id' => config('entities.ids.ability'),
    ])
    @include('entities.creator.selection._full', ['key' => 'abilities'])
</div>

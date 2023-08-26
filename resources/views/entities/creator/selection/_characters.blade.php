<div class="option flex">

    @include('entities.creator.selection._main', [
        'singular' => 'character',
        'plural' => 'characters',
        'icon' => config('entities.icons.character'),
        'id' => config('entities.ids.character'),
    ])
    @include('entities.creator.selection._full', ['key' => 'characters'])
</div>

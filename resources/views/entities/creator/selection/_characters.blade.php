<div class="option flex">

    @include('entities.creator.selection._main', [
        'singular' => 'character',
        'plural' => 'characters',
        'id' => config('entities.ids.character'),
    ])
    @include('entities.creator.selection._full', ['key' => 'characters'])
</div>

<div class="option flex">

    @include('entities.creator.selection._main', [
        'singular' => 'note',
        'plural' => 'notes',
        'id' => config('entities.ids.note'),
    ])
    @include('entities.creator.selection._full', ['key' => 'notes'])
</div>

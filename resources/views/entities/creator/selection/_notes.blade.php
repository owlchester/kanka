<div class="option flex gap-2">

    @include('entities.creator.selection._main', [
        'singular' => 'note',
        'plural' => 'notes',
        'id' => config('entities.ids.note'),
    ])
    @include('entities.creator.selection._full', ['key' => 'notes'])
</div>

<div class="option flex">

    @include('entities.creator.selection._main', [
        'singular' => 'note',
        'plural' => 'notes',
        'icon' => 'fa-solid fa-book-open',
        'id' => config('entities.ids.note'),
    ])
    @include('entities.creator.selection._full', ['key' => 'notes'])
</div>

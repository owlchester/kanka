<div class="option flex">

    @include('entities.creator.selection._main', [
        'singular' => 'journal',
        'plural' => 'journals',
        'id' => config('entities.ids.journal'),
    ])
    @include('entities.creator.selection._full', ['key' => 'journals'])
</div>

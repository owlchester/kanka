<div class="option flex">

    @include('entities.creator.selection._main', [
        'singular' => 'journal',
        'plural' => 'journals',
        'icon' => 'ra ra-quill-ink'
    ])
    @include('entities.creator.selection._full', ['key' => 'journals'])
</div>

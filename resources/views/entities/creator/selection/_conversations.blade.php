<div class="option flex">

    @include('entities.creator.selection._main', [
        'singular' => 'conversation',
        'plural' => 'conversations',
        'icon' => 'fa-solid fa-comment'
    ])
    @include('entities.creator.selection._full', ['key' => 'conversations'])
</div>

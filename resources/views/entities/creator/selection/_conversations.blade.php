<div class="option flex">

    @include('entities.creator.selection._main', [
        'singular' => 'conversation',
        'plural' => 'conversations',
        'id' => config('entities.ids.conversation'),
    ])
    @include('entities.creator.selection._full', ['key' => 'conversations'])
</div>

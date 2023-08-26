<div class="option flex">

    @include('entities.creator.selection._main', [
        'singular' => 'item',
        'plural' => 'items',
        'icon' => config('entities.icons.item'),
        'id' => config('entities.ids.item'),
    ])
    @include('entities.creator.selection._full', ['key' => 'items'])
</div>

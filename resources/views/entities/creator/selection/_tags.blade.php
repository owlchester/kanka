<div class="option flex">

    @include('entities.creator.selection._main', [
        'singular' => 'tag',
        'plural' => 'tags',
        'icon' => 'fa-solid fa-tags'
    ])
    @include('entities.creator.selection._full', ['key' => 'tags'])
</div>

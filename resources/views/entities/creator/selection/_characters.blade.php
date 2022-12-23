<div class="option flex">

    @include('entities.creator.selection._main', [
        'singular' => 'character',
        'plural' => 'characters',
        'icon' => 'fa-solid fa-user'
    ])
    @include('entities.creator.selection._full', ['key' => 'characters'])
</div>

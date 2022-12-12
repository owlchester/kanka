<div class="option flex">

    @include('entities.creator.selection._main', [
        'singular' => 'event',
        'plural' => 'events',
        'icon' => 'fa-solid fa-bolt'
    ])
    @include('entities.creator.selection._full', ['key' => 'events'])
</div>

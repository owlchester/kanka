<div class="option flex">

    @include('entities.creator.selection._main', [
        'singular' => 'timeline',
        'plural' => 'timelines',
        'icon' => 'fa-solid fa-hourglass'
    ])
    @include('entities.creator.selection._full', ['key' => 'timelines'])
</div>

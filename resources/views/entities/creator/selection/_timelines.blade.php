<div class="option flex">

    @include('entities.creator.selection._main', [
        'singular' => 'timeline',
        'plural' => 'timelines',
        'icon' => config('entities.icons.timeline'),
        'id' => config('entities.ids.timeline'),
    ])
    @include('entities.creator.selection._full', ['key' => 'timelines'])
</div>

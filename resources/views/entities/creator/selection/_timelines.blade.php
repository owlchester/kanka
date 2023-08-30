<div class="option flex gap-2">

    @include('entities.creator.selection._main', [
        'singular' => 'timeline',
        'plural' => 'timelines',
        'id' => config('entities.ids.timeline'),
    ])
    @include('entities.creator.selection._full', ['key' => 'timelines'])
</div>

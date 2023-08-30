<div class="option flex gap-2">

    @include('entities.creator.selection._main', [
        'singular' => 'location',
        'plural' => 'locations',
        'id' => config('entities.ids.location'),
    ])

    @include('entities.creator.selection._full', ['key' => 'locations'])
</div>

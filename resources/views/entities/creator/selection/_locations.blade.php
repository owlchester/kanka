<div class="option flex">

    @include('entities.creator.selection._main', [
        'singular' => 'location',
        'plural' => 'locations',
        'id' => config('entities.ids.location'),
    ])

    @include('entities.creator.selection._full', ['key' => 'locations'])
</div>

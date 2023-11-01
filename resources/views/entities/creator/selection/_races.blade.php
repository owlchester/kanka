<div class="option flex gap-2">

    @include('entities.creator.selection._main', [
        'singular' => 'race',
        'plural' => 'races',
        'id' => config('entities.ids.race'),
    ])
    @include('entities.creator.selection._full', ['key' => 'races'])
</div>

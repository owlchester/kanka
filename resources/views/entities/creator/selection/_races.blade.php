<div class="option flex">

    @include('entities.creator.selection._main', [
        'singular' => 'race',
        'plural' => 'races',
        'icon' => 'ra ra-wyvern',
        'id' => config('entities.ids.race'),
    ])
    @include('entities.creator.selection._full', ['key' => 'races'])
</div>

<div class="option flex">

    @include('entities.creator.selection._main', [
        'singular' => 'creature',
        'plural' => 'creatures',
        'icon' => 'ra ra-raven',
        'id' => config('entities.ids.creature'),
    ])
    @include('entities.creator.selection._full', ['key' => 'creatures'])
</div>

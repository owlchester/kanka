<div class="option flex">

    @include('entities.creator.selection._main', [
        'singular' => 'organisation',
        'plural' => 'organisations',
        'icon' => 'ra ra-hood',
        'id' => config('entities.ids.organisation'),
    ])

    @include('entities.creator.selection._full', ['key' => 'organisations'])
</div>

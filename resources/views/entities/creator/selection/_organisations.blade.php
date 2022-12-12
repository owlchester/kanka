<div class="option flex">

    @include('entities.creator.selection._main', [
        'singular' => 'organisation',
        'plural' => 'organisations',
        'icon' => 'ra ra-hood'
    ])

    @include('entities.creator.selection._full', ['key' => 'organisations'])
</div>

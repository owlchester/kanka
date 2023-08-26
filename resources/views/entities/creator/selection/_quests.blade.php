<div class="option flex">

    @include('entities.creator.selection._main', [
        'singular' => 'quest',
        'plural' => 'quests',
        'icon' => config('entities.icons.quest'),
        'id' => config('entities.ids.quest'),
    ])
    @include('entities.creator.selection._full', ['key' => 'quests'])
</div>

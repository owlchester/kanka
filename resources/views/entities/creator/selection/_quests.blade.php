<div class="option flex gap-2">

    @include('entities.creator.selection._main', [
        'singular' => 'quest',
        'plural' => 'quests',
        'id' => config('entities.ids.quest'),
    ])
    @include('entities.creator.selection._full', ['key' => 'quests'])
</div>

<div class="entity-grid">
    @include('entities.components.header', [
        'model' => $model,
        'breadcrumb' => [
            ['url' => Breadcrumb::index('quests'), 'label' => \App\Facades\Module::plural(config('entities.ids.quest'), __('entities.quests'))],
            null
        ]
    ])

    @include('entities.components.menu_v2', ['active' => 'story'])

    <div class="entity-story-block">
        @include('entities.components.posts', ['withEntry' => true])
        @includeWhen($model->quests()->has('quest')->count() > 0, 'quests.panels.quests')
    </div>

    <div class="entity-sidebar">
        @include('entities.components.pins')
    </div>
</div>

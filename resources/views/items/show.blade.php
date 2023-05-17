<div class="entity-grid">

    @include('entities.components.header', [
        'model' => $model,
        'breadcrumb' => [
            ['url' => Breadcrumb::index('items'), 'label' => \App\Facades\Module::plural(config('entities.ids.item'), __('entities.items'))],
            null
        ]
    ])

    @include('entities.components.menu_v2', ['active' => 'story'])

    <div class="entity-story-block">
        @include('entities.components.posts', ['withEntry' => true])
        @includeWhen($model->items()->has('item')->count() > 0, 'items.panels.items')
        @include('entities.pages.logs.history')
    </div>

    <div class="entity-sidebar">
        @include('entities.components.pins')
    </div>
</div>

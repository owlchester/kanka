<div class="entity-grid">

    @include('entities.components.menu_link_header', [
        'model' => $model,
        'breadcrumb' => [
            ['url' => Breadcrumb::index($name), 'label' => __('entities.' . $name)],
            null
        ]
    ])
    <div class="entity-main-block">
        @include('entities.pages.logs.history')
    </div>
</div>

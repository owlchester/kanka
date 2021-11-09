<div class="entity-grid">
    @include('entities.components.header_grid', [
        'model' => $model,
        'breadcrumb' => [
            ['url' => Breadcrumb::index($name), 'label' => __($name . '.index.title')],
            null
        ]
    ])

    @include($name . '._menu', ['active' => 'story', 'withPins'])

    <div class="entity-main-block">

        @include('entities.components.entry')
        @include('calendars._calendar')
        @include('entities.components.notes')

        @include('cruds.partials.mentions')
        @include('cruds.boxes.history')
    </div>
</div>

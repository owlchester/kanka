
<div class="entity-grid">

    @include('entities.components.header_grid', [
        'model' => $model,
        'breadcrumb' => [
            ['url' => Breadcrumb::index($name), 'label' => __($name . '.index.title')],
            null
        ]
    ])

    @include($name . '._menu', ['active' => 'story'])

    <div class="entity-story-block">

        @include('entities.components.notes')

        <div class="box box-solid">
                @include('dice_rolls._results')
        </div>

        @include('cruds.partials.mentions')
        @include('cruds.boxes.history')
    </div>

    <div class="entity-sidebar">
        @include('entities.components.pins')
    </div>
</div>


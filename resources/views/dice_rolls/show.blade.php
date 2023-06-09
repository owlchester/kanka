
<div class="entity-grid">

    @include('entities.components.header', [
        'model' => $model,
        'breadcrumb' => [
            ['url' => Breadcrumb::index($name), 'label' => __('entities.' . $name)],
            null
        ]
    ])

    @include('entities.components.menu_v2', ['active' => 'story'])

    <div class="entity-story-block">

        @include('entities.components.posts')

        @include('dice_rolls._results')
    </div>

    <div class="entity-sidebar">
        @include('entities.components.pins')
    </div>
</div>


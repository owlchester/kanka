<?php /** @var \App\Models\Tag $model */?>
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
        @include('entities.components.notes', ['withEntry' => true])
        @include('tags.panels.children')

        @include('cruds.partials.mentions')
        @include('entities.pages.logs.history')
    </div>

    <div class="entity-sidebar">
        @include('entities.components.pins')
    </div>
</div>

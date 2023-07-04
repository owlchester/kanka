<?php /** @var \App\Models\Tag $model */?>
<div class="entity-grid">
    @include('entities.components.header', [
        'model' => $model,
        'breadcrumb' => [
            ['url' => Breadcrumb::index('tags'), 'label' => \App\Facades\Module::plural(config('entities.ids.tag'), __('entities.tags'))],
            null
        ]
    ])

    @include('entities.components.menu_v2', ['active' => 'story'])

    <div class="entity-story-block">
        @include('entities.components.posts', ['withEntry' => true])
        @include('tags.panels.children', ['onload' => true])
    </div>

    <div class="entity-sidebar">
        @include('entities.components.pins')
    </div>
</div>

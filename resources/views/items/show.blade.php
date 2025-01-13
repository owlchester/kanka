<div class="entity-grid flex flex-col gap-5">

    @include('entities.components.header', [
        'breadcrumb' => [
            Breadcrumb::entity($entity)->list(),
        ]
    ])

    <div class="entity-body flex flex-col md:flex-row gap-5">
        @include('entities.components.menu_v2', ['active' => 'story'])

        <div class="entity-main-block grow flex flex-col gap-5 min-w-0">
            @include('entities.components.posts', ['withEntry' => true])
            @includeWhen($entity->child->children()->has('parent')->count() > 0, 'items.panels.items')
        </div>

        @include('entities.components.pins')
    </div>
</div>

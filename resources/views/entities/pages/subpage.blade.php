@include('partials.errors')
@include('ads.top')


<div class="entity-grid flex flex-col gap-5">
    @include('entities.components.header', [
        'entity' => $entity,
        'breadcrumb' => [
            Breadcrumb::entity($entity)->list(),
        ]
    ])

    <div class="entity-body flex flex-col md:flex-row gap-5">
        @include('entities.components.menu_v2', [
            'active' => $active,
        ])

        <div class="entity-main-block grow flex flex-col gap-5 min-w-0">
            @includeIf($view)
        </div>
    </div>
</div>

@inject('attributeService', 'App\Services\AttributeService')

<div class="entity-grid flex flex-col gap-5">

    @include('entities.components.header', [
        'model' => $model,
        'breadcrumb' => [
            Breadcrumb::entity($model->entity)->list(),
        ]
    ])

    <div class="entity-body flex flex-col md:flex-row gap-5">
        @include('entities.components.menu_v2', ['active' => 'story'])

        <div class="entity-main-block grow flex flex-col gap-5 min-w-0">
            @include('entities.components.posts', ['withEntry' => true])
            @includeWhen($model->entity->entityAttributes->count() > 0, 'entities.pages.attributes._story', ['entity' => $model->entity])

            @includeWhen($model->children()->has('parent')->count() > 0, 'abilities.panels.abilities', ['onload' => true])
        </div>

        @include('entities.components.pins')
    </div>
</div>



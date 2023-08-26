@inject('attributeService', 'App\Services\AttributeService')

<div class="entity-grid">

    @include('entities.components.header', [
        'model' => $model,
        'breadcrumb' => [
            Breadcrumb::entity($model->entity)->list(),
        ]
    ])

    @include('entities.components.menu_v2', ['active' => 'story'])

    <div class="entity-story-block">

        @include('entities.components.posts', ['withEntry' => true])
        @includeWhen($model->entity->entityAttributes->count() > 0, 'entities.pages.attributes._story', ['entity' => $model->entity])

        @includeWhen($model->abilities()->has('ability')->count() > 0, 'abilities.panels.abilities', ['onload' => true])
    </div>

    @include('entities.components.pins')
</div>



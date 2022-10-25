@inject('attributeService', 'App\Services\AttributeService')
@inject('campaignService', 'App\Services\CampaignService')

<div class="entity-grid">

    @include('entities.components.header', [
        'model' => $model,
        'breadcrumb' => [
            ['url' => Breadcrumb::index($name), 'label' => __('entities.abilities')],
            null
        ]
    ])

    @include($name . '._menu', ['active' => 'story'])

    <div class="entity-story-block">

        @include('entities.components.notes', ['withEntry' => true])
        @includeWhen($model->entity->entityAttributes->count() > 0, 'entities.pages.attributes._story', ['entity' => $model->entity])

        @include('cruds.partials.mentions')
        @includeWhen($model->abilities()->has('ability')->count() > 0, 'abilities.panels.abilities', ['onload' => true])
        @include('entities.pages.logs.history')
    </div>

    <div class="entity-sidebar">
        @include('entities.components.pins')
    </div>
</div>



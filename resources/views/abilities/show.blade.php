@inject('attributeService', 'App\Services\AttributeService')

<div class="row entity-grid">
    <div class="col-md-2 entity-sidebar-submenu">
        @include('journals._menu', ['active' => 'story'])
    </div>

    <div class="col-md-8 entity-story-block">
        @include('entities.components.entry')
        @include('entities.components.notes')
        @includeWhen($model->entity->entityAttributes->count() > 0, 'entities.pages.attributes._story', ['entity' => $model->entity])
        @include('cruds.partials.mentions')
        @include('cruds.boxes.history')
    </div>

    <div class="col-md-2 entity-sidebar-pins">
        @include('entities.components.pins')
    </div>
</div>





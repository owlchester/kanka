<?php /**
 * @var \App\Models\Map $model
 */
?>
@if ($model->map)
    <div class="entity-header-sub-element">
        <x-icon :class="\App\Facades\Module::duoIcon('map')" :title="__('crud.fields.parent')" />
        <x-entity-link
            :entity="$model->map->entity"
            :campaign="$campaign" />
    </div>
@endif

@includeWhen($model->location, 'entities.headers.__location')



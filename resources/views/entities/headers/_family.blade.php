<?php /**
 * @var \App\Models\Family $model
 */
?>
@if($model->family)
    <div class="entity-header-sub-element">
        <x-icon :class="\App\Facades\Module::duoIcon('family')" :title="__('crud.fields.parent')" />
        <x-entity-link
            :entity="$model->family->entity"
            :campaign="$campaign" />
    </div>
@endif
@include('entities.headers.__location')

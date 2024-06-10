<?php /**
 * @var \App\Models\Race $model
 */
?>
@if ($model->race)
    <div class="entity-header-sub-element">
        <x-icon :class="\App\Facades\Module::duoIcon('race')" :title="__('crud.fields.parent')" />
        <x-entity-link
            :entity="$model->race->entity"
            :campaign="$campaign" />
    </div>
@endif

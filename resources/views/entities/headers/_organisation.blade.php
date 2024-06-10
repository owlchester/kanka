<?php /**
 * @var \App\Models\Organisation $model
 */
?>
@if ($model->organisation)
    <div class="entity-header-sub-element">
        <x-icon :class="\App\Facades\Module::duoIcon('organisation')" :title="__('crud.fields.parent')" />
        <x-entity-link
            :entity="$model->organisation->entity"
            :campaign="$campaign" />
    </div>
@endif

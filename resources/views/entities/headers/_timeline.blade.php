<?php /**
 * @var \App\Models\Timeline $model
 */
?>
@if ($model->timeline)
    <div class="entity-header-sub entity-header-line">
        <div class="entity-header-sub-element">
            <x-icon :class="\App\Facades\Module::duoIcon('timeline')" :title="__('crud.fields.parent')" />
            <x-entity-link
                :entity="$model->timeline->entity"
                :campaign="$campaign" />
        </div>
    </div>
@endif

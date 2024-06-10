<?php /**
 * @var \App\Models\Note $model
 */
?>
@if ($model->note)
    <div class="entity-header-sub-element">
        <x-icon :class="\App\Facades\Module::duoIcon('note')" :title="__('crud.fields.parent')" />
        <x-entity-link
            :entity="$model->note->entity"
            :campaign="$campaign" />
    </div>
@endif

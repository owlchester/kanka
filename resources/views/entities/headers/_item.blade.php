<?php /**
 * @var \App\Models\Item $model
 */
?>
@if ($model->item)
    <div class="entity-header-sub entity-header-line">
        <div class="entity-header-sub-element">
            <x-icon :class="\App\Facades\Module::duoIcon('item')" :title="__('crud.fields.parent')" />
            <x-entity-link
                :entity="$model->item->entity"
                :campaign="$campaign" />
        </div>
    </div>
@endif

<?php /**
 * @var \App\Models\Quest $model
 */
?>
@if ($model->quest)
    <div class="entity-header-sub pull-left">
        <div class="entity-header-sub-element">
            <x-icon :class="\App\Facades\Module::duoIcon('quest')" :title="__('crud.fields.parent')" />
            <x-entity-link
                :entity="$model->quest->entity"
                :campaign="$campaign" />
        </div>
    </div>
@endif

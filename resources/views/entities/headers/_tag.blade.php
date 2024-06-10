<?php /**
 * @var \App\Models\Tag $model
 */
?>
@if ($model->tag)
    <div class="entity-header-sub pull-left">
        <div class="entity-header-sub-element">
            <x-icon :class="\App\Facades\Module::duoIcon('tag')" :title="__('crud.fields.parent')" />
            <x-entity-link
                :entity="$model->tag->entity"
                :campaign="$campaign" />
        </div>
    </div>
@endif

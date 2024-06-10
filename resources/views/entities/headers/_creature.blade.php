<?php /**
 * @var \App\Models\Creature $model
 */
?>
@if ($model->creature)
    <div class="entity-header-sub entity-header-line">
        <div class="entity-header-sub-element">
            <x-icon :class="\App\Facades\Module::duoIcon('creature')" :title="__('crud.fields.parent')" />
            <x-entity-link
                :entity="$model->creature->entity"
                :campaign="$campaign" />
        </div>
    </div>
@endif

<?php /**
 * @var \App\Models\Ability $model
 */
?>
@if ($model->ability)
    <div class="entity-header-sub-element">
        <span data-title="{{ __('crud.fields.parent') }}" data-toggle="tooltip">
            <x-icon :class="\App\Facades\Module::duoIcon('ability')" :title="__('crud.fields.parent')" />
            <x-entity-link
                :entity="$model->ability->entity"
                :campaign="$campaign" />
        </span>
    </div>
@endif

<?php /**
 * @var \App\Models\Race $model
 */
?>
@if ($model->race)
    <div class="entity-header-sub pull-left">
        <span>
            <x-icon :class="\App\Facades\Module::duoIcon('race')" :title="__('crud.fields.parent')" />
            {!! $model->race->tooltipedLink() !!}
        </span>
    </div>
@endif

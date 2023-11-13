<?php /**
 * @var \App\Models\Organisation $model
 */
?>
@if ($model->organisation)
    <div class="entity-header-sub pull-left">
        <x-icon :class="\App\Facades\Module::duoIcon('organisation')" :title="__('crud.fields.parent')" />
        {!! $model->organisation->tooltipedLink() !!}
    </div>
@endif

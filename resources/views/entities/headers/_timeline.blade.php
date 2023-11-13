<?php /**
 * @var \App\Models\Timeline $model
 */
?>
@if ($model->timeline)
    <div class="entity-header-sub pull-left">
        <span data-title="{{ __('crud.fields.parent') }}" data-toggle="tooltip">
            <x-icon :class="\App\Facades\Module::duoIcon('timeline')" :title="__('crud.fields.parent')" />
            {!! $model->timeline->tooltipedLink() !!}
        </span>
    </div>
@endif

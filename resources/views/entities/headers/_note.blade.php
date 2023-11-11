<?php /**
 * @var \App\Models\Note $model
 */
?>
@if ($model->note)
    <div class="entity-header-sub pull-left">
        <span data-title="{{ \App\Facades\Module::singular(config('entities.ids.note'), __('entities.note')) }}" data-toggle="tooltip">
            <x-icon :class="\App\Facades\Module::duoIcon('note')" :title="__('crud.fields.parent')" />
            {!! $model->note->tooltipedLink() !!}
        </span>
    </div>
@endif

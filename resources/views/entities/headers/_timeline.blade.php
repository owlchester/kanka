<?php /**
 * @var \App\Models\Timeline $model
 */
?>
@if ($model->timeline)
    <div class="entity-header-sub pull-left">
        <span data-title="{{ __('crud.fields.parent') }}" data-toggle="tooltip">
        <i class="fa-solid fa-hourglass-half" aria-hidden="true"></i>
        {!! $model->timeline->tooltipedLink() !!}
        </span>
    </div>
@endif

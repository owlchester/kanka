<?php /**
 * @var \App\Models\Calendar $model
 */
?>
@if ($model->date)
    <div class="entity-header-sub pull-left">
        <span title="{{ __('calendars.fields.date') }}" data-toggle="tooltip">
        <i class="fa-solid fa-clock" aria-hidden="true"></i>
        {!! $model->niceDate() !!}
        </span>
    </div>
@endif

<?php /**
 * @var \App\Models\Calendar $model
 */
?>
@if ($model->date)
    <div class="entity-header-sub-element">
        <span data-title="{{ __('calendars.fields.date') }}" data-toggle="tooltip">
            <x-icon class="fa-solid fa-clock" />
            {!! $model->niceDate() !!}
        </span>
    </div>
@endif

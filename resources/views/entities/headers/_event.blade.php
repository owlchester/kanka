<?php /**
 * @var \App\Models\Event $model
 */
?>
@if ($model->date || $model->event)
    <div class="entity-header-sub pull-left">
        @if($model->event)
        <span title="{{ __('crud.fields.parent') }}" data-toggle="tooltip" class="mr-2">
        <i class="fa-solid fa-bolt" aria-hidden="true"></i>
        {!! $model->event->tooltipedLink() !!}
        </span>
        @endif

        @if($model->date)
            <span title="{{ __('events.fields.date') }}" data-toggle="tooltip">
                <i class="fa-solid fa-calendar-day" aria-hidden="true"></i> {{ $model->date }}
            </span>
        @endif
    </div>
@endif

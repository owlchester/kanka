<?php /**
 * @var \App\Models\Event $model
 */
?>
@if ($model->date || $model->event)
    <div class="entity-header-sub pull-left">
        @if($model->event)
        <span data-title="{{ __('crud.fields.parent') }}" data-toggle="tooltip" class="mr-2">
            <x-icon :class="\App\Facades\Module::duoIcon('event')" :title="__('crud.fields.parent')" />
            {!! $model->event->tooltipedLink() !!}
        </span>
        @endif

        @if($model->date)
            <span data-title="{{ __('events.fields.date') }}" data-toggle="tooltip">
                <i class="fa-solid fa-calendar-day" aria-hidden="true"></i> {{ $model->date }}
            </span>
        @endif
    </div>
@endif

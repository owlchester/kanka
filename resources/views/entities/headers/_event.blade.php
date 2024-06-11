<?php /**
 * @var \App\Models\Event $model
 */
?>
@if($model->event)
    <div class="entity-header-sub-element">
        <x-icon :class="\App\Facades\Module::duoIcon('event')" :title="__('crud.fields.parent')" />
        <x-entity-link
            :entity="$model->event->entity"
            :campaign="$campaign" />
    </div>
@endif

@if($model->date)
    <div class="entity-header-sub-element">
        <span data-title="{{ __('events.fields.date') }}" data-toggle="tooltip">
            <x-icon class="fa-solid fa-calendar-day" /> {{ $model->date }}
        </span>
    </div>
@endif

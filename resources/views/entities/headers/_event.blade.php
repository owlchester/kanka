<?php /**
 * @var \App\Models\Event $model
 */
?>
@includeWhen($model->parent, 'entities.headers.__parent', ['module' => 'event'])

@if($model->date)
    <div class="entity-header-sub-element">
        <span data-title="{{ __('events.fields.date') }}" data-toggle="tooltip">
            <x-icon class="fa-solid fa-calendar-day" /> {{ $model->date }}
        </span>
    </div>
@endif

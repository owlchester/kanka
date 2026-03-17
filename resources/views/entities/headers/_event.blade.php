@includeWhen($entity->parent, 'entities.headers.__parent')

@if($entity->child->date)
    <div class="entity-header-sub-element">
        <span data-title="{{ __('events.fields.date') }}" data-toggle="tooltip">
            <x-icon class="fa-regular fa-calendar-day" /> {{ $entity->child->date }}
        </span>
    </div>
@endif

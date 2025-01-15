@includeWhen($entity->child->parent, 'entities.headers.__parent', ['module' => 'journal'])
@if($entity->child->date)
    <div class="entity-header-sub-element">
        <span data-title="{{ __('journals.fields.date') }}" data-toggle="tooltip">
            <x-icon class="fa-solid fa-calendar-day" />
            {{ $entity->child->date }}
        </span>
    </div>
@endif

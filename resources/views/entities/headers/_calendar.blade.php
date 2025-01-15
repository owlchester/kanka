@if ($entity->child->date)
    <div class="entity-header-sub-element">
        <span data-title="{{ __('calendars.fields.date') }}" data-toggle="tooltip">
            <x-icon class="fa-solid fa-clock" />
            {!! $entity->child->niceDate() !!}
        </span>
    </div>
@endif

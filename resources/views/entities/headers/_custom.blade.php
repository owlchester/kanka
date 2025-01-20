@if ($entity->parent)
    <div class="entity-header-sub-element">
        <span class="" data-title="{{ __('crud.fields.parent') }}" data-toggle="tooltip">
            <x-icon :class="$entity->entityType->icon()" />
        </span>
        <x-entity-link
            :entity="$entity->parent"
            :campaign="$campaign" />
    </div>
@endif

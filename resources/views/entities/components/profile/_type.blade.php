@if (!empty($entity->type))
    <div class="element profile-type">
        <div class="title text-uppercase text-xs">{{ __('crud.fields.type') }}</div>
        @if ($entity->entityType->isSpecial())
            <a href="{{ route('entities.index', [$campaign, $entity->entityType] + ['_clean' => true, 'type' => $entity->type]) }}">{!! $entity->type !!}</a>
        @else
            <a href="{{ route($entity->entityType->pluralCode() . '.index', [$campaign] + ['_clean' => true, 'type' => $entity->type]) }}">{!! $entity->type !!}</a>
        @endif
    </div>
@endif

@if (!empty($entity->type))
    <div class="element profile-type">
        <div class="title text-uppercase text-xs">{{ __('crud.fields.type') }}</div>
        @auth
            @if ($entity->entityType->isCustom())
                    <a href="{{ route('entities.index', [$campaign, $entity->entityType] + ['_clean' => true, 'type' => $entity->type]) }}" class="text-link">
                        {!! $entity->type !!}
                    </a>
            @else
                    <a href="{{ route($entity->entityType->pluralCode() . '.index', [$campaign] + ['_clean' => true, 'type' => $entity->type]) }}" class="text-link">
                        {!! $entity->type !!}
                    </a>
            @endif
        @else
            {!! $entity->type !!}
        @endauth
    </div>
@endif

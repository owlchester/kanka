@if (!empty($entity->type))
    <div class="element profile-type">
        <div class="title text-uppercase text-xs">{{ __('crud.fields.type') }}</div>
        @auth
            <a href="{{ route('entities.index', [$campaign, $entity->entityType] + ['_clean' => true, 'type' => $entity->type]) }}" class="text-link">
                {!! $entity->type !!}
            </a>
        @else
            {!! $entity->type !!}
        @endauth
    </div>
@endif

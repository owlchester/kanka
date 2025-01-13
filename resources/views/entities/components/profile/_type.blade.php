@if (!empty($child->type))
    <div class="element profile-type">
        <div class="title text-uppercase text-xs">{{ __('crud.fields.type') }}</div>
        @php
        $defaultOptions = [$campaign, $entity->entityType];
        @endphp
        <a href="{{ route('entities.index', $defaultOptions + ['_clean' => true, 'type' => $child->type]) }}">{!! $child->type !!}</a>
    </div>
@endif

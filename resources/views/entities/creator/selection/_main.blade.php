@php
/** @var \App\Models\EntityType $entityType $entityType */
@endphp
<a href="#" class="quick-creator-selection flex gap-2 items-center min-w-0 text-link" data-toggle="entity-creator" data-url="{{ route('entity-creator.form', [$campaign, 'entity_type' => $entityType]) }}" data-entity-type="{{ $entityType->code }}" aria-label="Reveal {{ $entityType->name() }} quick creator form">
    <div class="w-4 text-center">
        <x-icon class=" {{ $entityType->icon() }}" />
    </div>
    <span class="truncate block">
        {!! $entityType->name() !!}
    </span>
</a>

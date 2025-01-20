@php
/** @var \App\Models\EntityType $entityType $entityType */
@endphp
<a href="#" class="quick-creator-selection flex gap-2 overflow-hidden items-center" data-toggle="entity-creator" data-url="{{ route('entity-creator.form', [$campaign, 'entity_type' => $entityType]) }}" data-entity-type="{{ $entityType->code }}" aria-label="Reveal {{ $entityType->name() }} quick creator form">
    <x-icon class="w-4 text-center {{ $entityType->icon() }}" />
    <span class="overflow-hidden">{!! $entityType->name() !!}</span>
</a>

<a href="{{ $entityType->isSpecial() ? route('entities.create', [$campaign, $entityType]) : route($entityType->pluralCode() . '.create', $campaign) }}" class="full-form" aria-label="{{ __('entities.creator.actions.full') }}" data-title="{{ __('entities.creator.actions.full') }}" data-toggle="tooltip">
    <x-icon class="fa-regular fa-pen-to-square" />
    <span class="sr-only">Go to the full form for creating a new {{ $entityType->name() }}</span>
</a>


<div class="flex flex-stretch gap-2 items-center">
    <div class="text-muted grow">
        <x-icon class="fa-regular fa-filter" />
        {{ __('filters.helpers.guest') }}
    </div>

    @if ($filterService->activeFiltersCount() > 0)
        @if (isset($entityType) && $entityType->isCustom())
            <a href="{{ route('entities.index', [$campaign, $entityType, 'reset-filter' => 'true']) }}" class="btn2 btn-ghost btn-sm">
                <x-icon class="fa-regular fa-eraser" /> {{ __('crud.filters.clear') }}
            </a>
        @else
            <a href="{{ route($route . '.index', [$campaign, 'reset-filter' => 'true']) }}" class="btn2 btn-ghost btn-sm">
                <x-icon class="fa-regular fa-eraser" /> {{ __('crud.filters.clear') }}
            </a>
        @endif
    @endif
</div>
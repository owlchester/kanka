@php
/**
 * @var \App\Services\FilterService $filterService
 */
$activeFilters = $filterService->activeFiltersCount();
@endphp


<div class="grow flex gap-2">
    <div class="inline-block cursor-pointer btn2 btn-sm break-keep" data-toggle="dialog" data-target="datagrid-filters" data-url="{{ isset($entityType) ? route('filters.form', [$campaign, $entityType, 'm' => $mode]) : route('filters.form-connection', [$campaign, 'm' => $mode]) }}">
        <x-icon class="fa-regular fa-filter" />
        <span class="hidden sm:inline">{{ __('crud.filters.title') }}</span>
        @if ($activeFilters > 0)
            <x-badge type="primary">
                {{ $activeFilters }}
            </x-badge>
        @endif
    </div>

    @if ($activeFilters > 0)
        @if (empty($bookmark) && isset($entityType))
        @can('create', \App\Models\Bookmark::class)
            <div class="inline-block cursor-pointer btn2 btn-sm btn-primary break-keep" role="button" aria-label="{{ __('filters.actions.bookmark') }}" data-toggle="dialog" data-target="datagrid-filters" data-url="{{ route('filters.modal_form', [$campaign, $entityType, 'm' => $mode]) }}">
                <x-icon class="fa-regular fa-bookmark" />
                <span class="hidden sm:inline">{{ __('filters.actions.bookmark') }}</span>
            </div>
        @endcan
        @endif
        @if (isset($entityType) && $entityType->isCustom())
            <a href="{{ route('entities.index', [$campaign, $entityType, 'reset-filter' => 'true']) }}" class="btn2 btn-ghost btn-sm">
                <x-icon class="fa-regular fa-eraser" /> {{ __('crud.filters.clear') }}
            </a>
        @else
            <a href="{{ route($route, [$campaign, 'reset-filter' => 'true']) }}" class="btn2 btn-ghost btn-sm">
                <x-icon class="fa-regular fa-eraser" /> {{ __('crud.filters.clear') }}
            </a>
        @endif
    @endif
</div>

@section('modals')
    @parent()
    <x-dialog id="datagrid-filters" :loading="true" full="true">

    </x-dialog>
@endsection

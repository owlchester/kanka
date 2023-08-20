@php
/**
 * @var \App\Services\FilterService $filterService
 */
$activeFilters = $filterService->activeFiltersCount();
@endphp


<div class="grow flex gap-2">
    <div class="inline-block cursor-pointer btn2 btn-sm break-keep" data-toggle="dialog" data-target="datagrid-filters" data-url="{{ $model->entityTypeId() !== 0 ? route('filters.form', [$campaign, $model->entityTypeId(), 'm' => $mode]) : route('filters.form-connection', [$campaign, 'm' => $mode]) }}">
        <i class="fa-solid fa-filter" aria-hidden="true"></i>
        <span class="hidden-xs">{{ __('crud.filters.title') }}</span>
        @if ($activeFilters > 0)
            <x-badge type="primary">
                {{ $activeFilters }}
            </x-badge>
        @endif
    </div>

    @if ($activeFilters > 0)
        <a href="{{ route($route, [$campaign, 'm' => $mode, 'reset-filter' => 'true']) }}" class="p-1.5">
            <i class="fa-solid fa-eraser" aria-hidden="true"></i> {{ __('crud.filters.clear') }}
        </a>
    @endif
</div>

@section('modals')
    @parent()
    <x-dialog id="datagrid-filters" :loading="true" full="true">

    </x-dialog>
@endsection

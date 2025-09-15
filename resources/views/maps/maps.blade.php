@extends('layouts.app', [
    'title' => $entity->name . ' ' . $entity->entityType->plural(),
    'description' => '',
    'breadcrumbs' => false,
    'mainTitle' => false,
])


@section('entity-header-actions')
    <div class="header-buttons flex gap-2 items-center justify-end flex-wrap">
        @if ($mode === \App\Enums\Descendants::Direct)
            <a href="{{ route('maps.maps', [$campaign, $model, 'm' => \App\Enums\Descendants::All]) }}" class="btn2 btn-sm" data-toggle="tooltip" data-title="{{ __('crud.filters.lists.paginated') }}">
                <x-icon class="filter" />
                <span class="hidden lg:inline">{{ __('crud.filters.all') }}</span>
                ({{ $model->descendants->count() }})
            </a>
        @else
            <a href="{{ route('maps.maps', [$campaign, $model, 'm' => \App\Enums\Descendants::Direct, '#map-maps']) }}" class="btn2 btn-sm" data-toggle="tooltip" data-title="{{ __('crud.filters.lists.paginated') }}">
                <x-icon class="filter" />
                <span class="hidden lg:inline">{{ __('crud.filters.direct') }}</span>
                ({{ $model->children->count() }})
            </a>
        @endif
        @include('entities.headers.actions', ['edit' => false])
    </div>
@endsection

@section('content')
    @include('entities.pages.subpage', [
        'active' => 'maps',
        'view' => 'maps.panels.maps',
    ])
@endsection

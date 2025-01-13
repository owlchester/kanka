@extends('layouts.app', [
    'title' => __('maps/groups.index.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $model,
])


@section('entity-header-actions')
    <div class="header-buttons flex gap-2 items-center justify-end flex-wrap">
        @can('update', $model)
            <a href="https://docs.kanka.io/en/latest/entities/maps/groups.html" class="btn2 btn-sm" target="_blank">
                <x-icon class="question" />
                <span class="hidden xl:inline">{{ __('crud.actions.help') }}</span>
            </a>
            @if ($model->explorable())
                <a href="{{ route('maps.explore', [$campaign, $model]) }}" class="btn2 btn-primary btn-sm">
                    <x-icon class="map" />
                    <span class="hidden xl:inline">{{ __('maps.actions.explore') }}</span>
                </a>
            @endif
            <a href="{{ route('maps.map_groups.create', [$campaign, $model]) }}" class="btn2 btn-sm"
                data-toggle="dialog" data-target="primary-dialog"
                data-url="{{ route('maps.map_groups.create', [$campaign, $model]) }}"
            >
                <x-icon class="plus" />
                <span class="hidden xl:inline">{{ __('maps/groups.actions.add') }}</span>
            </a>
        @endcan
        @include('entities.headers.actions', ['edit' => false])
    </div>
@endsection

@section('content')

    @include('entities.pages.subpage', [
        'active' => 'groups',
        'breadcrumb' => __('maps.panels.groups'),
        'view' => 'maps.panels.groups',
        'entity' => $model->entity,
    ])
@endsection

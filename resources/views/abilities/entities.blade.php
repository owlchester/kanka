@extends('layouts.app', [
    'title' => $entity->name . ' - ' . __('abilities.show.tabs.entities'),
    'description' => '',
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $model ?? $entity,
])

@section('entity-header-actions')
    <div class="header-buttons flex flex-wrap gap-2 items-center justify-end">
        @can('update', $model)
            <a href="{{ route('abilities.entity-add', [$campaign, $model]) }}" class="btn2 btn-sm"
               data-toggle="dialog" data-target="primary-dialog" data-url="{{ route('abilities.entity-add', [$campaign, $model]) }}">
                <x-icon class="plus" /> <span class="hidden md:inline">{{ __('abilities.children.actions.attach') }}</span>
            </a>
        @endcan
        @include('entities.headers.actions', ['edit' => false])
    </div>
@endsection


@section('content')
    @include('entities.pages.subpage', [
        'active' => 'entities',
        'breadcrumb' => __('abilities.show.tabs.entities'),
        'view' => 'abilities.panels.entities',
        'entity' => $model->entity,
    ])
@endsection

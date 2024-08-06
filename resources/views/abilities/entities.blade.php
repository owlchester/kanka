@extends('layouts.app', [
    'title' => $model->name . ' - ' . __('abilities.show.tabs.entities'),
    'description' => '',
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $model,
])

@section('entity-header-actions')
    @can('update', $model)
        <div class="header-buttons inline-block ml-auto">
            <a href="{{ route('abilities.entity-add', [$campaign, $model]) }}" class="btn2 btn-sm"
               data-toggle="dialog" data-target="primary-dialog" data-url="{{ route('abilities.entity-add', [$campaign, $model]) }}">
                <x-icon class="plus" /> <span class="hidden md:inline">{{ __('abilities.children.actions.attach') }}</span>
            </a>
        </div>
    @endcan
@endsection


@section('content')
    @include('entities.pages.subpage', [
        'active' => 'entities',
        'breadcrumb' => __('abilities.show.tabs.entities'),
        'view' => 'abilities.panels.entities',
        'entity' => $model->entity,
    ])
@endsection

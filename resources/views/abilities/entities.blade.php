@extends('layouts.app', [
    'title' => $model->name . ' - ' . __('abilities.show.tabs.entities'),
    'description' => '',
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $model,
])

@section('entity-header-actions')
    @can('update', $model)
        <div class="header-buttons inline-block pull-right ml-auto">
            <a href="{{ route('abilities.entity-add', [$campaign, $model]) }}" class="btn2 btn-accent btn-sm"
               data-toggle="dialog" data-target="primary-dialog" data-url="{{ route('abilities.entity-add', [$campaign, $model]) }}">
                <x-icon class="plus"></x-icon> <span class="hidden-sm hidden-xs">{{ __('abilities.children.actions.add') }}</span>
            </a>
        </div>
    @endcan
@endsection


@section('content')
    @include('partials.errors')

    <div class="entity-grid">
        @include('entities.components.header', [
            'model' => $model,
            'breadcrumb' => [
                Breadcrumb::entity($model->entity)->list(),
                __('abilities.show.tabs.entities')
            ]
        ])

        @include('entities.components.menu_v2', ['active' => 'entities'])

        <div class="entity-main-block">
            @include('abilities.panels.entities')
        </div>
    </div>
@endsection

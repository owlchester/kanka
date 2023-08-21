@extends('layouts.app', [
    'title' => __('timelines/eras.index.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $model,
])


@section('entity-header-actions')
    @can('update', $model)
        <div class="header-buttons flex gap-2 items-center justify-end">
            <a href="{{ route('timelines.timeline_eras.create', [$campaign, 'timeline' => $model]) }}" class="btn2 btn-accent btn-sm"
            >
                <x-icon class="plus"></x-icon>
                {{ __('timelines/eras.actions.add') }}
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
                __('timelines.fields.eras')
            ]
        ])
        @include('entities.components.menu_v2', ['active' => 'eras'])
        <div class="entity-main-block">
            @include('timelines.panels.eras')
            @includeWhen(false && $rows->count() > 1, 'timelines.eras._reorder')
        </div>
    </div>
@endsection

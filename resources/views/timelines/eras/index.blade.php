@extends('layouts.app', [
    'title' => __('timelines/eras.index.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $model,
])


@section('entity-header-actions')
    @can('update', $model)
        <div class="header-buttons flex gap-2 items-center justify-end flex-wrap">
            <a href="{{ route('timelines.timeline_eras.create', [$campaign, 'timeline' => $model]) }}" class="btn2 btn-sm"
            >
                <x-icon class="plus" />
                <span class="hidden lg:inline">{{ __('timelines/eras.actions.add') }}</span>
            </a>
        </div>
    @endcan
@endsection

@section('content')
    @include('entities.pages.subpage', [
        'active' => 'eras',
        'breadcrumb' => __('timelines.fields.eras'),
        'view' => 'timelines.panels.eras',
        'entity' => $model->entity,
    ])
@endsection

@extends('layouts.app', [
    'title' => __('timelines/eras.index.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => false,
    'mainTitle' => false,
])


@section('entity-header-actions')
    <div class="header-buttons flex gap-2 items-center justify-end flex-wrap">
        @can('update', $model)
            <a href="{{ route('timelines.timeline_eras.create', [$campaign, 'timeline' => $model]) }}" class="btn2 btn-sm"
            >
                <x-icon class="plus" />
                <span class="hidden lg:inline">{{ __('timelines/eras.actions.add') }}</span>
            </a>
        @endcan
        @include('entities.headers.actions', ['edit' => false])
    </div>
@endsection

@section('content')
    @include('entities.pages.subpage', [
        'active' => 'eras',
        'breadcrumb' => __('timelines.fields.eras'),
        'view' => 'timelines.panels.eras',
    ])
@endsection

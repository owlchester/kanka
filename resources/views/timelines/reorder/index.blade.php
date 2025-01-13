<?php /**
 * @var \App\Models\TimelineEra $era */?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('timelines.reorder.title', ['name' => $timeline->name]),
    'breadcrumbs' => false,
    'mainTitle' => false,
    'bodyClass' => 'timeline-eras-reorder'
])


@section('content')
    @include('entities.pages.subpage', [
        'active' => 'reorder',
        'breadcrumb' => __('crud.actions.reorder'),
        'model' => $timeline,
        'view' => 'timelines.reorder._reorder',
        'entity' => $timeline->entity,
    ])
@endsection

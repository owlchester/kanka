<?php /** @var \App\Models\Entity $entity
 * @var \App\Models\EntityLog $log
 * @var \App\Models\EntityLog[]|\Illuminate\Pagination\LengthAwarePaginator $logs */?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/logs.show.title', ['name' => $entity->name]),
    'breadcrumbs' => false,
    'mainTitle' => false,
    'bodyClass' => 'entity-logs'
])
@include('entities.components.og')


@section('content')
    @include('entities.pages.subpage', [
        'active' => 'logs',
        'view' => 'entities.pages.logs._logs',
        'entity' => $entity,
    ])


@endsection

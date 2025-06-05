@extends('layouts.app', [
    'title' => $title,
    'skipTitle' => true,
    'seoTitle' => $title . ' - ' . $campaign->name,
    'breadcrumbs' => false,
    'canonical' => true,
    'bodyClass' => 'kanka-' . $entityType->code,
])

@section('content')
    @include('partials.errors')

    @include('ads.top')

    @include('entities.index.explore')
@endsection

@section('modals')
    @parent
    @includeWhen(auth()->check(), 'cruds.datagrids.bulks.modals')
    <x-dialog id="datagrid-filters" :loading="true" full="true" />
@endsection


@section('og')
    <meta property="og:description" content="{{ __('seo.entity-list', ['module' => $entityType->plural(), 'campaign' => $campaign->name]) }}" />
@endsection



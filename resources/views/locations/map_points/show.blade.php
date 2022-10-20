@extends('layouts.app', [
    'title' => __('locations.map.points.title', ['name' => $location->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('locations'), 'label' => __('entities.locations')],
        ['url' => route('locations.show', $location->id), 'label' => $location->name]
    ]
])
@section('content')
    @include('partials.errors')
    @include('locations.map_points._show')
@endsection

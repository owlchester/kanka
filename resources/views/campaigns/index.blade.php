@extends('layouts.app', [
    'title' => __('entities.campaign'),
    'breadcrumbs' => [
        ['url' => route('overview', $campaign), 'label' => __('entities.campaign')]
    ],
    'canonical' => true,
])

@section('content')
    @include('partials.errors')
    @include('campaigns._show')
@endsection

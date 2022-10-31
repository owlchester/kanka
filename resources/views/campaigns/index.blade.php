@extends('layouts.app', [
    'title' => __('entities.campaign'),
    'breadcrumbs' => [
        ['url' => route('campaigns.index'), 'label' => __('entities.campaign')]
    ],
    'canonical' => true,
])

@section('content')
    @include('partials.errors')
    @include('campaigns._show')
@endsection

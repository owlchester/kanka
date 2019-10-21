@extends('layouts.app', [
    'title' => trans('campaigns.index.title'),
    'description' => trans('campaigns.index.description'),
    'breadcrumbs' => [
        ['url' => route('campaigns.index'), 'label' => trans('campaigns.index.title')]
    ],
    'canonical' => true,
])

@section('content')
    @include('partials.errors')
    @include('campaigns._show')
@endsection

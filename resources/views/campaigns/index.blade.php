@extends('layouts.app', [
    'title' => trans('campaigns.index.title'),
    'description' => trans('campaigns.index.description'),
    'breadcrumbs' => [
        ['url' => route('campaigns.index'), 'label' => trans('campaigns.index.title')]
    ]
])

@section('content')
    @include('campaigns.show')
@endsection

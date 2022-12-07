@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => __('campaigns/default-images.create.title', ['name' => $campaign->name]),
    'breadcrumbs' => [
        ['url' => route('campaign.default-images'), 'label' => trans('campaigns/default-images.index.title')]
    ]
])

@section('content')

    {!! Form::open([
        'route' => ['campaign.default-images.store'],
        'method' => 'POST',
        'enctype' => 'multipart/form-data',
    ]) !!}
    @include('partials.forms.form', [
        'title' => __('campaigns/default-images.create.title', ['name' => $campaign->name]),
        'content' => 'campaigns.default-images._form',
    ])

    {!! Form::close() !!}
@endsection

@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => __('campaigns/default-images.create.title', ['name' => $campaign->name]),
    'breadcrumbs' => [
        ['url' => route('default-images', $campaign), 'label' => __('campaigns/default-images.index.title')]
    ]
])

@section('content')

    {!! Form::open([
        'route' => ['default-images.store', $campaign],
        'method' => 'POST',
        'enctype' => 'multipart/form-data',
    ]) !!}
    @include('partials.forms.form', [
        'title' => __('campaigns/default-images.create.title', ['name' => $campaign->name]),
        'content' => 'campaigns.default-images._form',
    ])

    {!! Form::close() !!}
@endsection

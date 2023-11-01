@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('tags.transfer.title', ['name' => $tag->name]),
    'breadcrumbs' => [
        Breadcrumb::entity($tag->entity)->list(),
        Breadcrumb::show($tag),
        __('tags.transfer.transfer'),
    ],
    'centered' => true,
])

@section('content')
    {!! Form::open(['route' => ['tags.transfer', [$campaign, $tag->id]], 'method' => 'POST']) !!}
        @include('partials.forms.form', [
            'title' => __('tags.transfer.transfer'),
            'content' => 'tags.transfer._form',
            'submit' =>  __('tags.transfer.transfer'),
            'dialog' => true,
        ])
    {!! Form::close() !!}
@endsection

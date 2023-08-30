@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('organisations.members.create.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => [
        Breadcrumb::entity($model->entity)->list(),
        Breadcrumb::show($model)
    ]
])

@section('content')
    {!! Form::open(array('route' => ['organisations.organisation_members.store', $campaign, $model->id], 'method'=>'POST')) !!}

    @include('partials.forms.form', [
        'title' => __('organisations.members.create.title', ['name' => $model->name]),
        'content' => 'organisations.members._form',
        'submit' => __('organisations.members.actions.submit'),
        'dialog' => true,
    ])
    {!! Form::hidden('organisation_id', $model->id) !!}
    {!! Form::close() !!}
@endsection

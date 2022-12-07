@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => __('organisations.members.create.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('organisations'), 'label' => __('entities.organisations')],
        ['url' => route('organisations.show', $model->id), 'label' => $model->name]
    ]
])

@section('content')
    {!! Form::open(array('route' => ['organisations.organisation_members.store', $model->id], 'method'=>'POST')) !!}

    @include('partials.forms.form', [
        'title' => __('organisations.members.create.title', ['name' => $model->name]),
        'content' => 'organisations.members._form',
    ])
    {!! Form::hidden('organisation_id', $model->id) !!}
    {!! Form::close() !!}
@endsection

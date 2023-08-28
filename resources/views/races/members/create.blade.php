@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('races.members.create.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => [
        Breadcrumb::entity($model->entity)->list(),
        Breadcrumb::show($model),
    ],
    'centered' => true,
])

@section('content')
    {!! Form::open(array('route' => ['races.members.store', $campaign, $model->id], 'method'=>'POST')) !!}

    @include('partials.forms.form', [
        'title' => __('races.members.create.title', ['name' => $model->name]),
        'content' => 'races.members._form',
        'submit' => __('races.members.create.submit')
    ])
    {!! Form::hidden('race_id', $model->id) !!}
    {!! Form::close() !!}
@endsection

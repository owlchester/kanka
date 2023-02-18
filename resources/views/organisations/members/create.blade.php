@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('organisations.members.create.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => $model->getLink('index'), 'label' => __('entities.organisations')],
        ['url' => $model->getLink(), 'label' => $model->name]
    ]
])

@section('content')
    {!! Form::open(array('route' => ['organisations.organisation_members.store', [$campaign->id, $model->id]], 'method'=>'POST')) !!}

    @include('partials.forms.form', [
        'title' => __('organisations.members.create.title', ['name' => $model->name]),
        'content' => 'organisations.members._form',
        'submit' => __('organisations.members.actions.submit')
    ])
    {!! Form::hidden('organisation_id', $model->id) !!}
    {!! Form::close() !!}
@endsection

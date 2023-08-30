@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('organisations.members.edit.title', ['name' => $model->name]),
    'breadcrumbs' => [
        Breadcrumb::entity($model->entity)->list(),
        Breadcrumb::show($model)
    ]
])
@section('content')
    {!! Form::model($member, ['method' => 'PATCH', 'route' => ['organisations.organisation_members.update', $campaign, $model->id, $member->id], 'data-shortcut' => 1]) !!}

    @include('partials.forms.form', [
        'title' => __('organisations.members.edit.title', ['name' => $model->name]),
        'content' => 'organisations.members._form',
        'dialog' => true,
    ])
    {!! Form::hidden('organisation_id', $model->id) !!}
    {!! Form::close() !!}
@endsection

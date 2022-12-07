@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => __('organisations.members.edit.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('organisations'), 'label' => __('entities.organisations')],
        ['url' => route('organisations.show', $model->id), 'label' => $model->name]
    ]
])
@section('content')
    {!! Form::model($member, ['method' => 'PATCH', 'route' => ['organisations.organisation_members.update', $model->id, $member->id], 'data-shortcut' => 1]) !!}

    @include('partials.forms.form', [
        'title' => __('organisations.members.edit.title', ['name' => $model->name]),
        'content' => 'organisations.members._form',
    ])
    {!! Form::hidden('organisation_id', $model->id) !!}
    {!! Form::close() !!}
@endsection

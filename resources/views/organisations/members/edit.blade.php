@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => trans('organisations.members.edit.title', ['name' => $model->name]),
    'description' => trans('organisations.members.edit.description'),
    'breadcrumbs' => [
        ['url' => route('organisations.index'), 'label' => trans('organisations.index.title')],
        ['url' => route('organisations.show', $model->id), 'label' => $model->name]
    ]
])
@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            @include('partials.errors')

            {!! Form::model($member, ['method' => 'PATCH', 'route' => ['organisations.organisation_members.update', $model->id, $member->id]]) !!}
            @include('organisations.members._form')
            {!! Form::hidden('organisation_id', $model->id) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection

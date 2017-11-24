@extends('layouts.app', [
    'title' => trans('organisations.members.edit.title', ['name' => $model->name]),
    'description' => trans('organisations.members.edit.description'),
    'breadcrumbs' => [
        ['url' => route('organisations.index'), 'label' => trans('organisations.index.title')],
        ['url' => route('organisations.show', $model->id), 'label' => $model->name]
    ]
])
@section('content')
    <div class="row">
        <div class="col-md-12 col-md-offset">
            <div class="panel panel-default">
                <div class="panel-body">
                    @include('partials.errors')

                    {!! Form::model($member, ['method' => 'PATCH', 'route' => ['organisations.organisation_members.update', $model->id, $member->id]]) !!}
                    @include('organisations.members._form')
                    {!! Form::hidden('organisation_id', $model->id) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app', [
    'title' => trans('organisations.members.create.title', ['name' => $model->name]),
    'description' => trans('organisations.members.create.description'),
    'breadcrumbs' => [
        ['url' => route('organisations.index'), 'label' => trans('organisations.index.title')],
        ['url' => route('organisations.show', $model->id), 'label' => $model->name]
    ]
])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    @include('partials.errors')

                    {!! Form::open(array('route' => ['organisations.organisation_members.store', $model->id], 'method'=>'POST')) !!}
                    @include('organisations.members._form')
                    {!! Form::hidden('organisation_id', $model->id) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

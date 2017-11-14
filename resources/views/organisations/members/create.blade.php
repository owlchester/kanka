@extends('layouts.app', [
    'title' => trans('organisations.members.create.title', ['name' => $organisation->name]),
    'description' => trans('organisations.members.create.description'),
    'breadcrumbs' => [
        ['url' => route('organisations.index'), 'label' => trans('organisations.index.title')],
        ['url' => route('organisations.show', $organisation->id), 'label' => $organisation->name]
    ]
])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    @include('partials.errors')

                    {!! Form::open(array('route' => 'organisation_member.store', 'method'=>'POST')) !!}
                    @include('organisations.members._form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

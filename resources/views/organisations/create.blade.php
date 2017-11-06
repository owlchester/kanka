@extends('layouts.app', [
    'title' => trans('organisations.create.title'),
    'description' => trans('organisations.create.description'),
    'breadcrumbs' => [
        ['url' => route('organisations.index'), 'label' => trans('organisations.index.title')],
        trans('crud.create'),
    ]
])
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    @include('partials.errors')

                    {!! Form::open(array('route' => 'organisations.store', 'enctype' => 'multipart/form-data', 'method'=>'POST')) !!}
                        @include('organisations._form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app', [
    'title' => trans('notes.create.title'),
    'description' => trans('notes.create.description'),
    'breadcrumbs' => [
        ['url' => route('notes.index'), 'label' => trans('notes.index.title')],
        trans('crud.create'),
    ]
])
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    @include('partials.errors')


                    {!! Form::open(array('route' => 'notes.store', 'enctype' => 'multipart/form-data', 'method'=>'POST')) !!}
                        @include('notes._form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

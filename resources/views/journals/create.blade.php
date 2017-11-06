@extends('layouts.app', [
    'title' => trans('journals.create.title'),
    'description' => trans('journals.create.description'),
    'breadcrumbs' => [
        ['url' => route('journals.index'), 'label' => trans('journals.index.title')],
        trans('crud.create'),
    ]
])
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    @include('partials.errors')

                    {!! Form::open(array('route' => 'journals.store', 'enctype' => 'multipart/form-data', 'method'=>'POST')) !!}
                        @include('journals._form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

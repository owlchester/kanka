@extends('layouts.app', [
    'title' => trans('locations.create.title'),
    'description' => trans('locations.create.description'),
    'breadcrumbs' => [
        ['url' => route('locations.index'), 'label' => trans('locations.index.title')],
        trans('crud.create'),
    ]
])
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    @include('partials.errors')

                    {!! Form::open(array('route' => 'locations.store', 'enctype' => 'multipart/form-data', 'method'=>'POST')) !!}
                        @include('locations._form', ['cancel' => route('locations.index')])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

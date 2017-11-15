@extends('layouts.app', [
    'title' => trans('families.create.title'),
    'description' => trans('families.create.description'),
    'breadcrumbs' => [
        ['url' => route('families.index'), 'label' => trans('families.index.title')],
        trans('crud.create'),
    ]
])
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    @include('partials.errors')


                    {!! Form::open(array('route' => 'families.store', 'enctype' => 'multipart/form-data', 'method'=>'POST')) !!}
                        @include('families._form', ['cancel' => route('families.index')])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

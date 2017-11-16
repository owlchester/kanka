@extends('layouts.app', [
    'title' => trans($name . '.create.title'),
    'description' => trans($name . '.create.description'),
    'breadcrumbs' => [
        ['url' => route($name . '.index'), 'label' => trans($name . 'rganisations.index.title')],
        trans('crud.create'),
    ]
])
@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('partials.errors')

            {!! Form::open(array('route' => $name . '.store', 'enctype' => 'multipart/form-data', 'method'=>'POST')) !!}
                @include($name . '._form', ['cancel' => route($name . '.index')])
            {!! Form::close() !!}
        </div>
    </div>
@endsection

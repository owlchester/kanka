@extends('layouts.app', [
    'title' => trans('characters.create.title'),
    'description' => trans('characters.create.description'),
    'breadcrumbs' => [
        ['url' => route('characters.index'), 'label' => trans('characters.index.title')],
        trans('crud.create'),
    ]
])

@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('partials.errors')

            {!! Form::open(array('route' => 'characters.store', 'enctype' => 'multipart/form-data', 'method'=>'POST')) !!}
                @include('characters._form', ['cancel' => route('characters.index')])
            {!! Form::close() !!}
        </div>
    </div>
@endsection

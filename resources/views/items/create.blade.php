@extends('layouts.app', [
    'title' => trans('items.create.title'),
    'description' => trans('items.create.description'),
    'breadcrumbs' => [
        ['url' => route('items.index'), 'label' => trans('items.index.title')],
        trans('crud.create'),
    ]
])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    @include('partials.errors')

                    {!! Form::open(array('route' => 'items.store', 'enctype' => 'multipart/form-data', 'method'=>'POST')) !!}
                        @include('items._form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

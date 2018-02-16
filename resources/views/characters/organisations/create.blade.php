@extends('layouts.app', [
    'title' => trans('characters.organisations.create.title', ['name' => $model->name]),
    'description' => trans('characters.organisations.create.description'),
    'breadcrumbs' => [
        ['url' => route('characters.index'), 'label' => trans('characters.index.title')],
        ['url' => route('characters.show', $model->id), 'label' => $model->name]
    ]
])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    @include('partials.errors')

                    {!! Form::open(array('route' => ['characters.character_organisations.store', $model->id], 'method'=>'POST', 'data-shortcut' => "1")) !!}
                    @include('characters.organisations._form')

                    {!! Form::hidden('character_id', $model->id) !!}
                    
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

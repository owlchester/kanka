@extends('layouts.app', [
    'title' => trans('entities/attributes.create.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => route($parentRoute . '.index'), 'label' => trans($parentRoute . '.index.title')],
        ['url' => route($parentRoute . '.show', $entity->child->id), 'label' => $entity->name]
    ]
])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">

                    <h1>Whoops</h1>
                    @dd('error 622')

                    @include('partials.errors')

                    {!! Form::open(array('route' => ['entities.attributes.store', $entity->id], 'method'=>'POST', 'data-shortcut' => "1")) !!}
                    @include('cruds.attributes._form')

                    <div class="form-group">
                        <button class="btn btn-success">{{ trans('crud.save') }}</button>
                        @include('partials.or_cancel')
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app', [
    'title' => trans('families.relations.create.title', ['name' => $family->name]),
    'description' => trans('families.relations.create.description'),
    'breadcrumbs' => [
        ['url' => route('families.index'), 'label' => trans('families.index.title')],
        ['url' => route('families.show', $family->id), 'label' => $family->name]
    ]
])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    @include('partials.errors')


                    {!! Form::open(array('route' => 'family_relation.store', 'method'=>'POST')) !!}
                    @include('families.relations._form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

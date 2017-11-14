@extends('layouts.app', [
    'title' => trans('locations.relations.create.title', ['name' => $location->name]),
    'description' => trans('locations.relations.create.description'),
    'breadcrumbs' => [
        ['url' => route('locations.index'), 'label' => trans('locations.index.title')],
        ['url' => route('locations.show', $location->id), 'label' => $location->name]
    ]
])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">

                <div class="panel-body">
                    @include('partials.errors')

                    {!! Form::open(array('route' => 'location_relation.store', 'method'=>'POST')) !!}
                        @include('locations.relations._form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

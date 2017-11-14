@extends('layouts.app', ['title' => trans('organisations.relations.create.title'), 'description' => trans('organisations.relations.create.description')])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">

                <div class="panel-body">
                    @include('partials.errors')

                    {!! Form::open(array('route' => 'organisation_relation.store', 'method'=>'POST')) !!}
                        @include('organisations.relations._form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

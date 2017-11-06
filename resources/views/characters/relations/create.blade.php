@extends('layouts.app', ['title' => trans('characters.relations.create.title'), 'description' => trans('characters.relations.create.description')])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">

                <div class="panel-body">
                    @include('partials.errors')

                    {!! Form::open(array('route' => 'character_relation.store', 'method'=>'POST')) !!}
                        @include('characters.relations._form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

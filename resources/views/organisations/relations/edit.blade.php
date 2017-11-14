@extends('layouts.app', ['title' => trans('organisations.relations.edit.title'), 'description' => trans('organisations.relations.edit.description')])

@section('content')
    <div class="row">
        <div class="col-md-12 col-md-offset">
            <div class="panel panel-default">

                <div class="panel-body">
                    @include('partials.errors')

                    {!! Form::model($relation, ['method' => 'PATCH', 'route' => ['organisation_relation.update', $relation->id]]) !!}
                        @include('organisations.relations._form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app', ['title' => trans('characters.relations.edit.title'), 'description' => trans('characters.relations.edit.description')])

@section('content')
    <div class="row">
        <div class="col-md-12 col-md-offset">
            <div class="panel panel-default">

                <div class="panel-body">
                    @include('partials.errors')

                    {!! Form::model($relation, ['method' => 'PATCH', 'route' => ['character_relation.update', $relation->id]]) !!}
                        @include('characters.relations._form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

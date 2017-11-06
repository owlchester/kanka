@extends('layouts.app', ['title' => trans('families.relations.edit.title'), 'description' => trans('families.relations.edit.description')])

@section('content')
    <div class="row">
        <div class="col-md-12 col-md-offset">
            <div class="panel panel-default">
                <div class="panel-body">
                    @include('partials.errors')

                    {!! Form::model($relation, ['method' => 'PATCH', 'route' => ['organisation_member.update', $relation->id]]) !!}
                    @include('organisations.members._form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

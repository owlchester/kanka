@extends('layouts.app', ['title' => trans('families.relations.edit.title'), 'description' => trans('families.relations.edit.description')])

@section('content')
    <div class="row">
        <div class="col-md-12 col-md-offset">
            <div class="panel panel-default">
                <div class="panel-heading">Edit membership</div>

                <div class="panel-body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {!! Form::model($relation, ['method' => 'PATCH', 'route' => ['organisation_member.update', $relation->id]]) !!}
                    @include('organisations.members._form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

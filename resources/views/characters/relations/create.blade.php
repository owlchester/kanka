@extends('layouts.app', ['title' => trans('characters.relations.create.title'), 'description' => trans('characters.relations.create.description')])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Create a new relation</div>

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


                    {!! Form::open(array('route' => 'character_relation.store', 'method'=>'POST')) !!}
                        @include('characters.relations._form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

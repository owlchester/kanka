@extends('layouts.app', ['title' => trans('journals.edit.title', ['journal' => $journal->name]), 'description' => trans('journals.edit.description')])

@section('content')
    <div class="row">
        <div class="col-md-12 col-md-offset">
            <div class="panel panel-default">
                <div class="panel-heading">Edit {{ $journal->name }}</div>

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

                    {!! Form::model($journal, ['method' => 'PATCH', 'enctype' => 'multipart/form-data', 'route' => ['journals.update', $journal->id]]) !!}
                        @include('journals._form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app', [
    'title' => trans('notes.show.title', ['note' => $note->name]),
    'description' => trans('notes.show.description'),
    'breadcrumbs' => [
        ['url' => route('notes.index'), 'label' => trans('notes.index.title')],
        ['url' => route('notes.show', $note->id), 'label' => $note->name],
        trans('crud.update'),
    ]
])
@section('content')
    <div class="row">
        <div class="col-md-12 col-md-offset">
            <div class="panel panel-default">
                <div class="panel-heading">Edit {{ $note->name }}</div>

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

                    {!! Form::model($note, ['method' => 'PATCH', 'enctype' => 'multipart/form-data', 'route' => ['notes.update', $note->id]]) !!}
                        @include('notes._form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

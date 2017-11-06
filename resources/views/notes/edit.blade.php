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
                <div class="panel-body">
                    @include('partials.errors')

                    {!! Form::model($note, ['method' => 'PATCH', 'enctype' => 'multipart/form-data', 'route' => ['notes.update', $note->id]]) !!}
                        @include('notes._form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

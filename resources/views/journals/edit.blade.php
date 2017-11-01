@extends('layouts.app', [
    'title' => trans('journals.show.title', ['journal' => $journal->name]),
    'description' => trans('journals.show.description'),
    'breadcrumbs' => [
        ['url' => route('journals.index'), 'label' => trans('journals.index.title')],
        ['url' => route('journals.show', $journal->id), 'label' => $journal->name],
        trans('crud.update'),
    ]
])
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

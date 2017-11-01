@extends('layouts.app', [
    'title' => trans('characters.show.title', ['character' => $character->name]),
    'description' => trans('characters.show.description'),
    'breadcrumbs' => [
        ['url' => route('characters.index'), 'label' => trans('characters.index.title')],
        ['url' => route('characters.show', $character->id), 'label' => $character->name],
        trans('crud.update'),
    ]
])

@section('content')
    <div class="row">
        <div class="col-md-12 col-md-offset">
            <div class="panel panel-default">
                <div class="panel-heading">Edit {{ $character->name }}</div>

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

                    {!! Form::model($character, ['method' => 'PATCH', 'enctype' => 'multipart/form-data', 'route' => ['characters.update', $character->id]]) !!}
                        @include('characters._form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

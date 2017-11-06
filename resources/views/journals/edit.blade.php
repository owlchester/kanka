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
                <div class="panel-body">
                    @include('partials.errors')

                    {!! Form::model($journal, ['method' => 'PATCH', 'enctype' => 'multipart/form-data', 'route' => ['journals.update', $journal->id]]) !!}
                        @include('journals._form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

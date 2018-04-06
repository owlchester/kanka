@extends('layouts.app', [
    'title' => trans('campaigns.edit.title', ['campaign' => $model->name]),
    'description' => trans('campaigns.edit.description'),
    'breadcrumbs' => [
        ['url' => route('campaigns.index'), 'label' => trans('campaigns.index.title')],
        ['url' => route('campaigns.show', $model->id), 'label' => $model->name],
        trans('crud.create')
    ]
])

@section('content')
    <div class="row">
        <div class="col-md-12 col-md-offset">
            <div class="panel panel-default">
                <div class="panel-body">
                    @include('partials.errors')

                    {!! Form::model($model, ['method' => 'PATCH', 'enctype' => 'multipart/form-data', 'route' => ['campaigns.update', $model->id]]) !!}
                        @include('campaigns._form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

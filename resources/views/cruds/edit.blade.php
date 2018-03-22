@extends('layouts.app', [
    'title' => trans($name . '.edit.title', ['name' => $model->name]),
    'description' => trans($name . '.edit.description'),
    'breadcrumbs' => [
        ['url' => route($name . '.index'), 'label' => trans($name . '.index.title')],
        ['url' => route($name . '.show', $model->id), 'label' => $model->name],
        trans('crud.update'),
    ]
])
@inject('campaign', 'App\Services\CampaignService')

@section('content')
    <div class="row">
        <div class="col-md-12 col-md-offset">
            @include('partials.errors')

            {!! Form::model($model, ['method' => 'PATCH', 'enctype' => 'multipart/form-data', 'route' => [$name . '.update', $model->id], 'data-shortcut' => "1"]) !!}
                @include($name . '._form', ['source' => null])
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@include('layouts.widgets.tinymce')
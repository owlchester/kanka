@extends('layouts.admin', [
    'title' => trans($trans . '.edit.title', ['name' => $model->name]),
    'breadcrumbs' => [
        ['url' => route($route . '.index'), 'label' => trans($trans . '.index.title')],
        $model->name,
        trans('crud.update'),
    ]
])
@inject('campaign', 'App\Services\CampaignService')


@section('content')
    <div class="row margin-bottom">
        <div class="col-md-12">
            @include('partials.errors')

            {!! Form::model($model, ['method' => 'PATCH', 'enctype' => 'multipart/form-data', 'route' => [$route . '.update', $model->id], 'data-shortcut' => '1']) !!}
            @include($name . '._form', ['source' => null])
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@include('editors.summernote')

@extends('layouts.admin', [
    'title' => trans($trans . '.create.title'),
    'breadcrumbs' => [
        ['url' => route($route . '.index'), 'label' => trans($trans . '.index.title')],
        trans('crud.create'),
    ]
])
@inject('campaign', 'App\Services\CampaignService')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('partials.errors')

            {!! Form::open(['route' => $route . '.store', 'enctype' => 'multipart/form-data', 'method' => 'POST', 'data-shortcut' => '1']) !!}
            @include($name . '._form', ['cancel' => route($route . '.index')])
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@include('editors.summernote')

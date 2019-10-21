@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => trans($name . '.create.title'),
    'description' => trans($name . '.create.description'),
    'breadcrumbs' => [
        ['url' => route($name . '.index'), 'label' => trans($name . '.index.title')],
        trans('crud.create'),
    ],
    'canonical' => true,
])
@inject('campaign', 'App\Services\CampaignService')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('partials.errors')

            {!! Form::open(['route' => $name . '.store', 'enctype' => 'multipart/form-data', 'method'=>'POST', 'data-shortcut' => '1']) !!}
                @include($name . '._form', ['cancel' => route($name . '.index'), 'source' => $source])
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@include('editors.editor')
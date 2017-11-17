@extends('layouts.app', [
    'title' => trans($name . '.create.title'),
    'description' => trans($name . '.create.description'),
    'breadcrumbs' => [
        ['url' => route($name . '.index'), 'label' => trans($name . '.index.title')],
        trans('crud.create'),
    ]
])
@inject('campaign', 'App\Services\CampaignService')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('partials.errors')

            {!! Form::open(array('route' => [$route . '.store', 'family' => $model, 'familyRelation' => $relation], 'method'=>'POST')) !!}
                @include($name . '._form', ['cancel' => route($name . '.index')])
            {!! Form::close() !!}
        </div>
    </div>
@endsection

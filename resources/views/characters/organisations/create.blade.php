@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('characters.organisations.create.title', ['name' => $model->name]),
    'breadcrumbs' => [
        ['url' => route('characters.index', ['campaign' => $model->campaign_id]), 'label' => __('entities.characters')],
        ['url' => $model->getLink(), 'label' => $model->name]
    ]
])

@section('content')
    @include('partials.errors')
    @include('characters.organisations._create')
@endsection

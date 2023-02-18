@extends('layouts.app', [
    'title' => __('characters.organisations.edit.title', ['name' => $model->name]),
    'breadcrumbs' => [
        ['url' => $model->getLink('index'), 'label' => __('entities.characters')],
        ['url' => $model->getLink(), 'label' => $model->name]
    ]
])

@section('content')
    @include('partials.errors')
    @include('characters.organisations._edit')
@endsection


@extends('layouts.app', [
    'title' => trans('characters.organisations.create.title', ['name' => $model->name]),
    'description' => trans('characters.organisations.create.description'),
    'breadcrumbs' => [
        ['url' => route('characters.index'), 'label' => trans('characters.index.title')],
        ['url' => route('characters.show', $model->id), 'label' => $model->name]
    ]
])

@section('content')
    @include('partials.errors')
    @include('characters.organisations._create')
@endsection

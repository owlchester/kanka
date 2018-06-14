@if (!$ajax)
@extends('layouts.app', [
    'title' => trans('organisations.members.create.title', ['name' => $model->name]),
    'description' => trans('organisations.members.create.description'),
    'breadcrumbs' => [
        ['url' => route('organisations.index'), 'label' => trans('organisations.index.title')],
        ['url' => route('organisations.show', $model->id), 'label' => $model->name]
    ]
])

@section('content')
    @include('organisations.members._create')
@endsection

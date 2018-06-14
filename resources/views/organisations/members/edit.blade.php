@extends('layouts.app', [
    'title' => trans('organisations.members.edit.title', ['name' => $model->name]),
    'description' => trans('organisations.members.edit.description'),
    'breadcrumbs' => [
        ['url' => route('organisations.index'), 'label' => trans('organisations.index.title')],
        ['url' => route('organisations.show', $model->id), 'label' => $model->name]
    ]
])
@section('content')
    @include('organisations.members._edit')
@endsection

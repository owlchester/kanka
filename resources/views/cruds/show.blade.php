@extends('layouts.app', [
    'title' => trans($name . '.show.title', ['name' => $model->name]),
    'description' => trans($name . '.show.description'),
    'breadcrumbs' => [
        ['url' => route($name . '.index'), 'label' => trans($name . '.index.title')],
        $model->name,
    ]
])

@section('content')
    @include($name . '.show')
@endsection

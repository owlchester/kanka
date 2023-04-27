@extends('layouts.app', [
    'title' => trans('characters.organisations.create.title', ['name' => $model->name]),
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('characters'), 'label' => \App\Facades\Module::plural(config('entities.ids.character'), __('entities.characters'))],
        ['url' => $model->geLink(), 'label' => $model->name]
    ]
])

@section('content')
    @include('partials.errors')
    @include('characters.organisations._create')
@endsection

@extends('layouts.app', [
    'title' => __('characters.organisations.create.title'),
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('characters'), 'label' => \App\Facades\Module::plural(config('entities.ids.character'), __('entities.characters'))],
        ['url' => $model->getLink(), 'label' => $model->name],
        \App\Facades\Module::plural(config('entities.ids.organisation'), __('entities.organisations'))
    ],
])

@section('content')
    @include('characters.organisations._create')
@endsection

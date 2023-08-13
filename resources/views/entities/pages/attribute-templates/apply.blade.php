@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/attributes.template.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        Breadcrumb::entity($entity)->list(),
        Breadcrumb::show(),
        __('entities.attribute_template')
    ]
])

@section('content')
    @include('partials.errors')
    @include('entities.pages.attribute-templates._form')
@endsection

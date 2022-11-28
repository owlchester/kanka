@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/attributes.template.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => $entity->url('index'), 'label' => __('entities.' . $entity->pluralType())],
        ['url' => $entity->url('show'), 'label' => $entity->name],
        __('entities.attribute_template')
    ]
])

@section('content')
    @include('partials.errors')
    @include('entities.pages.attribute-templates._form')
@endsection

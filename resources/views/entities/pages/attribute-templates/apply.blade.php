@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('crud.attributes.template.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => $entity->url('index'), 'label' => __($entity->pluralType() . '.index.title')],
        ['url' => $entity->url('show'), 'label' => $entity->name],
        __('crud.fields.attribute_template')
    ]
])

@section('content')
    @include('partials.errors')
    @include('entities.pages.attribute-templates._form')
@endsection

@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/attributes.template.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => Breadcrumb::index($entity->pluralType()), 'label' => \App\Facades\Module::plural($entity->typeId(), __('entities.' . $entity->pluralType()))],
        ['url' => $entity->url(), 'label' => $entity->name],
        __('entities.attribute_template')
    ]
])

@section('content')
    @include('partials.errors')
    @include('entities.pages.attribute-templates._form')
@endsection

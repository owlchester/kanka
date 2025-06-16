@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/attributes.template.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        Breadcrumb::campaign($campaign)->entity($entity)->list(),
        Breadcrumb::show(),
        __('entities.attribute_template')
    ],
    'centered' => true,
])

@section('content')
    @include('partials.errors')

    <x-form :action="['entities.attributes.template-process', $campaign, $entity->id]">
    @include('partials.forms._dialog', [
            'title' => __('entities.attribute_template'),
            'content' => 'entities.pages.attribute-templates._form',
            'actions' => 'entities.pages.attribute-templates._actions',
        ])
    </x-form>
@endsection

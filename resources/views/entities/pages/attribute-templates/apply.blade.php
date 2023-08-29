@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/attributes.template.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        Breadcrumb::entity($entity)->list(),
        Breadcrumb::show(),
        __('entities.attribute_template')
    ],
    'centered' => true,
])

@section('content')
    @include('partials.errors')

    {!! Form::open(['route' => ['entities.attributes.template', [$campaign, $entity->id]], 'method'=>'POST', 'data-shortcut' => '1', 'class' => 'ajax-subform']) !!}

    @include('partials.forms.form', [
            'title' => __('entities.attribute_template'),
            'content' => 'entities.pages.attribute-templates._form',
            'dialog' => true,
            'actions' => 'entities.pages.attribute-templates._actions',
        ])
    {!! Form::close() !!}
@endsection

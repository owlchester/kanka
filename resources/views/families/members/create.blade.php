@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => __('families.members.create.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('families'), 'label' => __('entities.families')],
        ['url' => route('families.show', $model->id), 'label' => $model->name]
    ]
])

@section('content')
    {!! Form::open(array('route' => ['families.character_family.store', $model->id], 'method'=>'POST')) !!}

    @include('partials.forms.form', [
        'title' => __('families.members.create.title', ['name' => $model->name]),
        'content' => 'families.members._form',
        'submit' => __('families.members.create.submit')
    ])
    {!! Form::hidden('family_id', $model->id) !!}
    {!! Form::close() !!}
@endsection

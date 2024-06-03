@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('families.members.create.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => [
        Breadcrumb::entity($model->entity)->list(),
        Breadcrumb::show($model)
    ],
    'centered' => true,
])

@section('content')
    {!! Form::open(['route' => ['families.members.store', $campaign, $model->id], 'method'=>'POST']) !!}

    @include('partials.forms.form', [
        'title' => __('families.members.create.title', ['name' => $model->name]),
        'content' => 'families.members._form',
        'submit' => __('families.members.create.submit'),
        'dialog' => true,
    ])
    <input type="hidden" name="family_id" value="{{ $model->id }}" />
    {!! Form::close() !!}
@endsection

@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('organisations.members.create.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('organisations'), 'label' => \App\Facades\Module::plural(config('entities.ids.organisation'), __('entities.organisations'))],
        ['url' => $model->getLink(), 'label' => $model->name]
    ]
])

@section('content')
    {!! Form::open(array('route' => ['organisations.organisation_members.store', $model->id], 'method'=>'POST')) !!}

    @include('partials.forms.form', [
        'title' => __('organisations.members.create.title', ['name' => $model->name]),
        'content' => 'organisations.members._form',
        'submit' => __('organisations.members.actions.submit')
    ])
    {!! Form::hidden('organisation_id', $model->id) !!}
    {!! Form::close() !!}
@endsection

@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => __('races.members.create.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('races'), 'label' => \App\Facades\Module::plural(config('entities.ids.race'), __('entities.races'))],
        ['url' => $model->getLink(), 'label' => $model->name]
    ]
])

@section('content')
    {!! Form::open(array('route' => ['races.members.store', $model->id], 'method'=>'POST')) !!}

    @include('partials.forms.form', [
        'title' => __('races.members.create.title', ['name' => $model->name]),
        'content' => 'races.members._form',
        'submit' => __('races.members.create.submit')
    ])
    {!! Form::hidden('race_id', $model->id) !!}
    {!! Form::close() !!}
@endsection

@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('characters.organisations.create.title'),
    'breadcrumbs' => [
        Breadcrumb::entity($model->entity)->list(),
        Breadcrumb::show($model),
        \App\Facades\Module::plural(config('entities.ids.organisation'), __('entities.organisations'))
    ],
    'centered' => true,
])

@section('content')
    {!! Form::open([
        'route' => ['characters.character_organisations.store', $campaign, $model->id],
        'method'=>'POST',
        'data-shortcut' => '1'
    ]) !!}

    @include('partials.forms.form', [
        'title' => __('characters.organisations.create.title'),
        'content' => 'characters.organisations._form',
        'submit' => __('crud.add'),
        'dialog' => true,
        'dropdownParent' => '#organisation-dialog',
    ])

    {!! Form::hidden('character_id', $model->id) !!}
    {!! Form::close() !!}
@endsection

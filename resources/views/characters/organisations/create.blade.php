@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('characters.organisations.create.title'),
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('characters'), 'label' => \App\Facades\Module::plural(config('entities.ids.character'), __('entities.characters'))],
        ['url' => $model->getLink(), 'label' => $model->name],
        \App\Facades\Module::plural(config('entities.ids.organisation'), __('entities.organisations'))
    ],
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

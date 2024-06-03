@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => trans('characters.organisations.edit.title', ['name' => $model->name]),
    'breadcrumbs' => [
        Breadcrumb::entity($model->entity)->list(),
        Breadcrumb::show($model)
    ],
    'centered' => true,
])

@section('content')
    @include('partials.errors')
    {!! Form::model($member, [
        'method' => 'PATCH',
        'route' => ['characters.character_organisations.update', $campaign, $model->id, $member->id],
        'data-shortcut' => 1
    ]) !!}

    @include('partials.forms.form', [
        'title' => __('characters.organisations.edit.title', ['name' => $model->name]),
        'content' => 'characters.organisations._form',
        'dialog' => true,
        'dropdownParent' => '#primary-dialog',
    ])

    <input type="hidden" name="character_id" value="{{ $model->id }}" />
    @if (request()->has('from'))
        <input type="hidden" name="from" value="{{ request()->get('from') }}" />
    @endif
    {!! Form::close() !!}

@endsection


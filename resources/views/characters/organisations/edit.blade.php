@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => trans('characters.organisations.edit.title', ['name' => $model->name]),
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('characters'), 'label' => \App\Facades\Module::plural(config('entities.ids.character'), __('entities.characters'))],
        ['url' => $model->getLink(), 'label' => $model->name]
    ]
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
    ])

    {!! Form::hidden('character_id', $model->id) !!}
    @if (request()->has('from'))
        <input type="hidden" name="from" value="{{ request()->get('from') }}" />
    @endif
    {!! Form::close() !!}

@endsection


@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('organisations.members.edit.title', ['name' => $model->name]),
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('organisations'), 'label' => \App\Facades\Module::plural(config('entities.ids.organisation'), __('entities.organisations'))],
        ['url' => $model->getLink(), 'label' => $model->name]
    ]
])
@section('content')
    {!! Form::model($member, ['method' => 'PATCH', 'route' => ['organisations.organisation_members.update', $campaign, $model->id, $member->id], 'data-shortcut' => 1]) !!}

    @include('partials.forms.form', [
        'title' => __('organisations.members.edit.title', ['name' => $model->name]),
        'content' => 'organisations.members._form',
    ])
    {!! Form::hidden('organisation_id', $model->id) !!}
    {!! Form::close() !!}
@endsection

@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => trans('campaigns.roles.edit.title', ['name' => $role->name]),
    'breadcrumbs' => [
        ['url' => route('overview', $campaign), 'label' => __('entities.campaign')],
        ['url' => route('campaign_roles.index', $campaign), 'label' => trans('campaigns.show.tabs.roles')],
        $role->name,
    ],
    'mainTitle' => false,
])

@section('content')
    {!! Form::model($role, ['method' => 'PATCH', 'route' => ['campaign_roles.update', 'campaign' => $campaign, 'campaign_role' => $role->id], 'data-shortcut' => 1, 'class' => 'entity-form']) !!}

    @include('partials.forms.form', [
            'title' => __('campaigns.roles.edit.title', ['name' => $role->name]),
            'content' => 'campaigns.roles._form',
            'submit' => __('campaigns.roles.actions.rename')
        ])
    {!! Form::close() !!}
@endsection

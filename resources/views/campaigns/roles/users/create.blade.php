@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('campaigns.roles.users.create.title', ['name' => $role->name]),
    'breadcrumbs' => [
        ['url' => route('overview', $campaign), 'label' => __('entities.campaign')],
        ['url' => route('campaign_roles.index', $campaign), 'label' => __('campaigns.show.tabs.roles')],
        ['url' => route('campaign_roles.show', [$campaign, $role]), 'label' => $role->name],
    ]
])

@section('content')
    @include('partials.errors')

    {!! Form::open(['route' => ['campaign_roles.campaign_role_users.store', 'campaign' => $campaign, 'campaign_role' => $role], 'method' => 'POST', 'data-shortcut' => 1]) !!}

    @include('partials.forms.form', [
        'title' => __('campaigns.roles.users.actions.add'),
        'content' => 'campaigns.roles.users._form',
        'submit' => __('campaigns.roles.users.actions.add')
    ])
    {!! Form::hidden('campaign_role_id', $role->id) !!}
    {!! Form::close() !!}
@endsection

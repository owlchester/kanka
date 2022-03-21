@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('campaigns.roles.users.create.title', ['name' => $role->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => route('campaigns.index'), 'label' => __('campaigns.index.title')],
        ['url' => route('campaign_roles.index'), 'label' => __('campaigns.show.tabs.roles')],
        ['url' => route('campaign_roles.show', $role), 'label' => $role->name],
    ]
])

@section('content')
    @include('partials.errors')

    {!! Form::open(['route' => ['campaign_roles.campaign_role_users.store', 'campaign_role' => $role], 'method' => 'POST', 'data-shortcut' => 1]) !!}
    <div class="panel panel-default">
        <div class="panel-body">
            @include('campaigns.roles.users._form')
        </div>
        <div class="panel-footer text-right">
            <button class="btn btn-success">{{ __('campaigns.roles.users.actions.add') }}</button>
            @includeWhen(!request()->ajax(), 'partials.or_cancel')
        </div>
    </div>
    {!! Form::hidden('campaign_role_id', $role->id) !!}
    {!! Form::close() !!}
@endsection

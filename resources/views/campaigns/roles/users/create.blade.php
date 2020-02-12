@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => trans('campaigns.roles.users.create.title', ['name' => $role->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => route('campaigns.index'), 'label' => trans('campaigns.index.title')],
        ['url' => route('campaigns.show', $campaign->id), 'label' => $campaign->name]
    ]
])

@section('content')
    @include('partials.errors')

    <div class="panel panel-default">
        <div class="panel-body">
            {!! Form::open(['route' => ['campaign_roles.campaign_role_users.store', 'campaign_role' => $role], 'method' => 'POST', 'data-shortcut' => 1]) !!}
            @include('campaigns.roles.users._form')

            {!! Form::hidden('campaign_role_id', $role->id) !!}

            {!! Form::close() !!}
        </div>
    </div>
@endsection

@extends('layouts.app', [
    'title' => trans('campaigns.roles.users.create.title', ['name' => $campaign->name]),
    'description' => trans('campaigns.roles.users.create.description'),
    'breadcrumbs' => [
        ['url' => route('campaigns.index'), 'label' => trans('campaigns.index.title')],
        ['url' => route('campaigns.show', $campaign->id), 'label' => $campaign->name]
    ]
])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    @include('partials.errors')

                    {!! Form::model($user, ['route' => ['campaign_roles.campaign_role_users.update', 'campaign_role' => $role, 'campaign_role_user' => $user], 'method'=>'PATCH', 'data-shortcut' => "1"]) !!}
                    @include('campaigns.roles.users._form')

                    {!! Form::hidden('campaign_role_id', $role->id) !!}

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

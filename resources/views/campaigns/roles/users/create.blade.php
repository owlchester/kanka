@extends('layouts.app', [
    'title' => trans('campaigns.roles.users.edit.title', ['name' => $campaign->name]),
    'description' => trans('campaigns.roles.users.edit.description'),
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

                    {!! Form::open(['route' => ['campaigns.campaign_roles.campaign_role_users.store', 'campaign' => $campaign, 'campaign_role' => $role, 'campaign_role_user' => $user], 'method'=>'POST', 'data-shortcut' => "1"]) !!}
                    @include('campaigns.roles.users._form')

                    {!! Form::hidden('campaign_role_id', $role->id) !!}
                    
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

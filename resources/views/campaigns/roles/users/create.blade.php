@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('campaigns.roles.users.create.title', ['name' => $role->name]),
    'breadcrumbs' => [
        ['url' => route('campaigns.index'), 'label' => __('entities.campaign')],
        ['url' => route('campaign_roles.index'), 'label' => __('campaigns.show.tabs.roles')],
        ['url' => route('campaign_roles.show', $role), 'label' => $role->name],
    ]
])

@section('content')
    @include('partials.errors')

    {!! Form::open(['route' => ['campaign_roles.campaign_role_users.store', 'campaign_role' => $role], 'method' => 'POST', 'data-shortcut' => 1]) !!}
        <div class="modal-body">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title mb-5">
                {!! __('campaigns.roles.users.actions.add') !!}
            </h4>

            @include('campaigns.roles.users._form')

            <div class="text-right mt-5">
                <button class="btn btn-success">
                    <i class="fa-solid fa-plus" aria-hidden="true"></i>
                    {{ __('campaigns.roles.users.actions.add') }}
                </button>
            </div>
        </div>
    {!! Form::hidden('campaign_role_id', $role->id) !!}
    {!! Form::close() !!}
@endsection

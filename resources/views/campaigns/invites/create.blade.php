@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('campaigns.invites.create.title', ['campaign' => $campaign->name]),
    'breadcrumbs' => [
        ['url' => route('campaign'), 'label' => __('campaigns.index.title')],
        ['url' => route('campaign_users.index'), 'label' => trans('campaigns.show.tabs.members')]
    ]
])

@section('content')
    {!! Form::open(array('route' => ['campaign_invites.store'], 'method' => 'POST')) !!}
    <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title mb-5">
            {!! __('campaigns.invites.actions.link') !!}
        </h4>

        @include('campaigns.invites._form')
    </div>
    <div class="modal-footer">
        <a href="#" type="button" class="block mr-5" data-dismiss="modal">
            {{ __('crud.cancel') }}
        </a>

        <button class="btn btn-success">
            <i class="fa-solid fa-link mr-2" aria-hidden="true"></i>
            {{ __('campaigns.invites.create.buttons.create') }}
        </button>
    </div>
    {!! Form::hidden('type_id', $typeID) !!}
    {!! Form::close() !!}
@endsection

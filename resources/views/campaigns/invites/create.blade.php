@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('campaigns.invites.create.title', ['campaign' => $campaign->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => route('campaign'), 'label' => __('campaigns.index.title')],
        ['url' => route('campaign_users.index'), 'label' => trans('campaigns.show.tabs.members')]
    ]
])

@section('content')
    {!! Form::open(array('route' => ['campaign_invites.store'], 'method' => 'POST')) !!}

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title">
            {!! __('campaigns.invites.create.title', ['campaign' => $campaign->name]) !!}
        </h4>
    </div>
    <div class="modal-body">
        @include('partials.errors')

        @include('campaigns.invites._form')
    </div>
    <div class="modal-footer">


            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">
                {{ __('crud.cancel') }}
            </button>

            <button class="btn btn-success">
                @if ($type == 'email')
                    {{ __('campaigns.invites.create.buttons.send') }}
                @else
                    {{ __('campaigns.invites.create.buttons.create') }}
                @endif
            </button>
    </div>
    {!! Form::close() !!}
@endsection

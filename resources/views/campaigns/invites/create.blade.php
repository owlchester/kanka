@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('campaigns.invites.create.title', ['campaign' => $campaign->name]),
    'breadcrumbs' => [
        ['url' => route('campaign'), 'label' => __('entities.campaign')],
        ['url' => route('campaign_users.index'), 'label' => __('campaigns.show.tabs.members')]
    ]
])

@section('content')
    {!! Form::open(['route' => ['campaign_invites.store'], 'method' => 'POST']) !!}

    @include('partials.forms.form', [
        'title' => __('campaigns.invites.actions.link'),
        'content' => 'campaigns.invites._form',
        'submit' => __('campaigns.invites.create.buttons.create')
    ])
    {!! Form::close() !!}
@endsection

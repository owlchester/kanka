@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('campaigns.invites.create.title', ['campaign' => $campaign->name]),
    'breadcrumbs' => [
        ['url' => route('overview', $campaign), 'label' => __('entities.campaign')],
        ['url' => route('campaign_users.index', $campaign), 'label' => __('campaigns.show.tabs.members')]
    ],
    'sidebar' => 'campaign',
])

@section('content')
    <x-form :action="['campaign_invites.store', $campaign]">
        @include('partials.forms.form', [
            'title' => __('campaigns.invites.actions.link'),
            'content' => 'campaigns.invites._form',
            'submit' => __('campaigns.invites.create.buttons.create'),
        ])
    </x-form>
@endsection

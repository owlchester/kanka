@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('campaigns.invites.create.title', ['campaign' => $campaign->name]),
    'breadcrumbs' => [
        ['url' => route('overview', $campaign), 'label' => __('entities.campaign')],
        ['url' => route('campaign_users.index', $campaign), 'label' => __('campaigns.show.tabs.members')]
    ]
])

@section('content')

@include('partials.forms.form', [
        'title' => __('campaigns.members.manage_roles') . ' - ' . $campaignUser->user->name,
        'content' => 'campaigns.members._form',
        'actions' => null,
        'dialog' => true,
    ])
@endsection

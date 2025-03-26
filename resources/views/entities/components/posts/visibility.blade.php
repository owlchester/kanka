@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('campaigns.invites.create.title', ['campaign' => $campaign->name]),
    'breadcrumbs' => [
        ['url' => route('overview', $campaign), 'label' => __('entities.campaign')],
        ['url' => route('campaign_users.index', $campaign), 'label' => __('campaigns.show.tabs.members')]
    ]
])

@section('content')
    <x-form :action="['posts.update.visibility', $campaign, $entity, $post]" class="post-visibility" direct>
        @include('partials.forms._dialog', [
            'title' => __('visibilities.title'),
            'content' => 'entities.components.posts._form',
            'model' => $post
        ])
    </x-form>
@endsection

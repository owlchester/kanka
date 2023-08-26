@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('campaigns.invites.create.title', ['campaign' => $campaign->name]),
    'breadcrumbs' => [
        ['url' => route('overview', $campaign), 'label' => __('entities.campaign')],
        ['url' => route('campaign_users.index', $campaign), 'label' => __('campaigns.show.tabs.members')]
    ]
])

@section('content')
    {!! Form::open([
        'route' => ['posts.update.visibility', $campaign, $entity, $post],
        'method' => 'POST',
        'class' => 'post-visibility'
    ]) !!}
        @include('partials.forms.form', [
            'title' => __('visibilities.title'),
            'content' => 'entities.components.posts._form',
            'dialog' => true
        ])

    {!! Form::close() !!}
@endsection

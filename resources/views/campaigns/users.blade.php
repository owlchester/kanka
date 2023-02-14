@extends('layouts.app', [
    'title' => __('campaigns.show.tabs.members') . ' - ' . $campaign->name,
    'breadcrumbs' => [
        ['url' => route('overview', $campaign), 'label' => __('entities.campaign')],
        __('campaigns.show.tabs.members')
    ],
    'canonical' => true,
    'mainTitle' => false,
])

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-md-3">
            @include('campaigns._menu', ['active' => 'users'])
        </div>
        <div class="col-md-9">
            @include('campaigns.members._users')

            @include('campaigns.members._invites')
        </div>
    </div>
@endsection

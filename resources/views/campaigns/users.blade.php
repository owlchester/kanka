@extends('layouts.app', [
    'title' => __('campaigns.members.title', ['name' => $campaign->name]),
    'description' => null,
    'breadcrumbs' => [
        ['url' => route('campaign'), 'label' => __('campaigns.index.title')],
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
            @include('campaigns._users')
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    <script src="{{ mix('js/campaign.js') }}" defer></script>
@endsection

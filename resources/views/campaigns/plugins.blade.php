@extends('layouts.app', [
    'title' => __('campaigns/plugins.title', ['name' => $campaign->name]),
    'description' => __('campaigns/plugins.description'),
    'breadcrumbs' => [
        __('campaigns.show.tabs.plugins')
    ],
    'canonical' => true,
    'mainTitle' => false,
])

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-md-3">
            @include('campaigns._menu', ['active' => 'plugins'])
        </div>
        <div class="col-md-9 campaign-plugins">
            @include('campaigns._plugins')
        </div>
    </div>
@endsection


@section('scripts')
    @parent
    <script src="{{ mix('js/campaign.js') }}" defer></script>
@endsection

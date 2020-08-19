@extends('layouts.app', [
    'title' => __('campaigns.settings.title', ['name' => $campaign->name]),
    'description' => __('campaigns.settings.description'),
    'breadcrumbs' => [
        ['url' => route('campaign'), 'label' => $campaign->name],
        __('campaigns.show.tabs.settings')
    ],
    'canonical' => true,
    'mainTitle' => false,
])

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-md-3">
            @include('campaigns._menu', ['active' => 'settings'])
        </div>
        <div class="col-md-9 campaign-settings">
            @include('campaigns._settings')
        </div>
    </div>
@endsection


@section('scripts')
    @parent
    <script src="{{ mix('js/campaign.js') }}" defer></script>
@endsection

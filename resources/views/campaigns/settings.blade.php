@extends('layouts.app', [
    'title' => __('campaigns.show.tabs.settings') . ' - ' . $campaign->name,
    'breadcrumbs' => [
        ['url' => route('campaign'), 'label' => __('entities.campaign')],
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

@extends('layouts.app', [
    'title' => __('campaigns/plugins.title', ['name' => $campaign->name]),
    'breadcrumbs' => [
        ['url' => route('overview', $campaign), 'label' => __('entities.campaign')],
        __('campaigns.show.tabs.plugins')
    ],
    'canonical' => true,
    'mainTitle' => false,
    'sidebar' => 'campaign',
])

@section('content')
    <div class="flex gap-5 flex-col campaign-plugins max-w-7xl">

        @include('partials.errors')
        @include('partials.ads.top')

        @if(session('plugin_entities_created'))
            <x-alert type="info" :dismissible="true">
                <strong>{{ __('campaigns/plugins.import.created') }}</strong><br/>
                {!! session('plugin_entities_created') !!}
            </x-alert>
        @endif
        @if(session('plugin_entities_updated'))
            <x-alert type="info" :dismissible="true">
                <strong>{{ __('campaigns/plugins.import.updated') }}</strong><br/>
                {!! session('plugin_entities_updated') !!}
            </x-alert>
        @endif
        @if(session('plugin_only_new') == 'on' && session('plugin_entities_created') == 0)
            <x-alert type="warning" :dismissible="true">
                <strong>{{ __('campaigns/plugins.import.no_new_entities') }}</strong><br/>
            </x-alert>
        @endif
        @include('campaigns.plugins.index')
    </div>
@endsection



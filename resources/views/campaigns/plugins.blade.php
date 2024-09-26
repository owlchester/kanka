@extends('layouts.app', [
    'title' => __('campaigns/plugins.title', ['name' => $campaign->name]),
    'breadcrumbs' => [
        __('campaigns.show.tabs.plugins')
    ],
    'canonical' => true,
    'mainTitle' => false,
    'sidebar' => 'campaign',
    'centered' => true,
])

@section('content')
    <div class="flex gap-5 flex-col campaign-plugins">

        @include('partials.errors')
        @include('ads.top')

        @if(session('plugin_entities_created'))
            <x-alert type="info" :dismissible="true">
                <strong>{{ __('campaigns/plugins.import.created') }}</strong><br/>
                <p>{!! session('plugin_entities_created') !!}</p>
            </x-alert>
        @endif
        @if(session('plugin_entities_updated'))
            <x-alert type="info" :dismissible="true">
                <strong>{{ __('campaigns/plugins.import.updated') }}</strong><br/>
                <p>{!! session('plugin_entities_updated') !!}</p>
            </x-alert>
        @endif
        @if(session('plugin_only_new') == 'on' && session('plugin_entities_created') == 0)
            <x-alert type="warning" :dismissible="true">
                <strong>{{ __('campaigns/plugins.import.no_new_entities') }}</strong>
            </x-alert>
        @endif
        @include('campaigns.plugins.index')
    </div>
@endsection



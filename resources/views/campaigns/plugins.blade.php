@extends('layouts.app', [
    'title' => __('campaigns/plugins.title', ['name' => $campaign->name]),
    'description' => __('campaigns/plugins.description'),
    'breadcrumbs' => [
        ['url' => route('campaign'), 'label' => __('campaigns.index.title')],
        __('campaigns.show.tabs.plugins')
    ],
    'canonical' => true,
    'mainTitle' => false,
])

@section('content')
    @include('partials.errors')

    @if(session('plugin_entities_created'))
        <div class="alert alert-info alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <strong>{{ __('campaigns/plugins.import.created') }}</strong><br />
            {!! session('plugin_entities_created') !!}
        </div>
    @endif
    @if(session('plugin_entities_updated'))
        <div class="alert alert-info alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <strong>{{ __('campaigns/plugins.import.updated') }}</strong><br />
            {!! session('plugin_entities_updated') !!}
        </div>
    @endif
    @if(session('plugin_only_new') == 'on' && session('plugin_entities_created') == 0)
        <div class="alert alert-warning alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <strong>{{ __('campaigns/plugins.import.no_new_entities') }}</strong><br />
        </div>
    @endif
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

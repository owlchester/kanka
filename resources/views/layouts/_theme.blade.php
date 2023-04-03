@if (!empty($themeOverride) && in_array($themeOverride, ['dark', 'midnight', 'base']))
    @php $specificTheme = $themeOverride; @endphp
    @if($themeOverride != 'base')
        @vite('resources/sass/themes/' . request()->get('_theme') . '.scss')
    @endif
@else
    @if (!empty($campaign) && $campaign->boosted() && !empty($campaign->theme_id))
        @if ($campaign->theme_id !== 1)
            @vite('resources/sass/themes/' . ($campaign->theme_id === 2 ? 'dark' : 'midnight') . '.scss')
            @php $specificTheme = ($campaign->theme_id === 2 ? 'dark' : 'midnight') @endphp
        @endif
    @elseif (auth()->check() && !empty(auth()->user()->theme))
        @vite('resources/sass/themes/' . auth()->user()->theme . '.scss')
        @php $specificTheme = auth()->user()->theme @endphp
    @endif
@endif

@if(!empty($campaign) && $campaign->boosted() && $campaign->hasPluginTheme() && request()->get('_plugins') !== '0')
    <link href="{{ route('campaign_plugins.css', ['ts' => $campaign->updated_at->getTimestamp()]) }}" rel="stylesheet">
@endif
@if (!empty($campaign) && $campaign->boosted() && request()->get('_styles') !== '0')
    <link href="{{ route('campaign.css', ['ts' => \App\Facades\CampaignCache::stylesTimestamp()]) }}" rel="stylesheet">
@endif

@if($campaign->boosted() && $campaign->hasPluginTheme() && request()->get('_plugins') !== '0')
    <link href="{{ route('campaign_plugins.css', [$campaign, 'ts' => $campaign->updated_at->getTimestamp()]) }}" rel="stylesheet">
@endif
@if ($campaign->boosted() && request()->get('_styles') !== '0')
    <link href="{{ route('campaign.css', [$campaign, 'ts' => \App\Facades\CampaignCache::stylesTimestamp()]) }}" rel="stylesheet">
@endif

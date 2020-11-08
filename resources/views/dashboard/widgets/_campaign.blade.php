<?php
/** @var \App\Models\Campaign $campaign */
?>
<div class="campaign @if(!empty($campaign->header_image))cover-background" style="background-image: url({{ Img::crop(1200, 400)->url($campaign->header_image) }}) @else no-header @endif ">
    <div class="content">
        <div class="title">
            <h1>
                @if (!empty($campaign->image))
                    <img class="img-circle cover-background" src="{{ Img::crop(50, 50)->url($campaign->image) }}" alt="{{ $campaign->name }} picture">
                @endif
                <a href="{{ route('campaigns.show', $campaign) }}" title="{!! $campaign->name !!}">{!! $campaign->name !!}</a>
            </h1>
        </div>
        @if ($campaign->hasPreview())
            <div class="preview">
                {!! $campaign->preview() !!}
            </div>
            <div class="more">
                <a href="{{ route('campaigns.show', $campaign) }}">{{ __('crud.actions.find_out_more') }}</a>
            </div>
        @endif

        @can('update', $campaign)
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-2">
                    <a href="{{ route('campaign_users.index') }}" class="campaign-link" title="{{ trans_choice('dashboard.campaigns.tabs.users', \App\Facades\CampaignCache::members()->count(), ['count' => \App\Facades\CampaignCache::members()->count()]) }}">
                        <i class="fa fa-user"></i> {{ \App\Facades\CampaignCache::members()->count() }}
                    </a>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-2">
                    <a href="{{ route('campaign_roles.index') }}" class="campaign-link" title="{{ trans_choice('dashboard.campaigns.tabs.roles', \App\Facades\CampaignCache::roles()->count(), ['count' => \App\Facades\CampaignCache::roles()->count()]) }}">
                        <i class="fa fa-lock"></i> {{ \App\Facades\CampaignCache::roles()->count() }}
                    </a>
                </div>
                <div class="col-md-2 hidden-xs hidden-sm">
                    <a href="{{ route('campaign_settings') }}" class="campaign-link" title="{{ trans_choice('dashboard.campaigns.tabs.modules', $campaign->setting->countEnabledModules(), ['count' => $campaign->setting->countEnabledModules()]) }}">
                        <i class="fa fa-cogs"></i> {{ $campaign->setting->countEnabledModules() }}
                    </a>
                </div>
            </div>
        @endcan
    </div>
</div>

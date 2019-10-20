<div class="campaign @if(!empty($campaign->header_image))cover-background" style="background-image: url({{ Storage::url($campaign->header_image) }}) @else no-header @endif ">
    <div class="content">
        <div class="title">
            <h1>
                @if (!empty($campaign->image))
                    <img class="img-circle cover-background" src="{{ Storage::url($campaign->image) }}" alt="{{ $campaign->name }} picture">
                @endif
                <a href="{{ route('campaigns.show', $campaign) }}" title="{{ $campaign->name }}">{{ $campaign->name }}</a>
            </h1>
        </div>
        @if ($campaign->hasPreview())
            <div class="preview">
                {!! $campaign->preview() !!}
            </div>
            <div class="more">
                <a href="{{ route('campaigns.show', $campaign) }}">{{ __('crud.actions.find_out_more') }}</a>
            </div>
        @else
            <div class="preview">
                <p class="help-block">{{ __('dashboard.campaigns.setup_preview') }}</p>
            </div>
        @endif

        @can('update', $campaign)
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-2">
                    <a href="{{ route('campaign_users.index') }}" class="campaign-link" title="{{ __('dashboard.campaigns.tabs.users', ['count' => $campaign->users()->count()]) }}">
                        <i class="fa fa-user"></i> {{ $campaign->users()->count() }}
                    </a>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-2">
                    <a href="{{ route('campaign_roles.index') }}" class="campaign-link" title="{{  __('dashboard.campaigns.tabs.roles', ['count' => $campaign->roles()->count()]) }}">
                        <i class="fa fa-lock"></i> {{ $campaign->roles()->count() }}
                    </a>
                </div>
                <div class="col-md-2 hidden-xs hidden-sm">
                    <a href="{{ route('campaign_settings') }}" class="campaign-link" title="{{ __('dashboard.campaigns.tabs.modules', ['count' => $campaign->setting->countEnabledModules()]) }}">
                        <i class="fa fa-cogs"></i> {{ $campaign->setting->countEnabledModules() }}
                    </a>
                </div>
            </div>
        @endcan
    </div>
</div>
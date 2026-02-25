<x-box class="widget-join" id="dashboard-widget-{{ $widget->id }}">
    <span class="widget-title block text-lg mb-3">
        {{ __('dashboards/widgets/join.title') }}
    </span>
    <div class="entity-content" id="players-wanted">
        <span>
            {!! $campaign->getFilter(\App\Enums\CampaignFilterType::Intro) !!}
        </span>

        <span>
            <h4 class="m-0 text-lg">{{ __('campaigns/applications.fields.schedule') }}</h4>
            {!! $campaign->getFilter(\App\Enums\CampaignFilterType::Schedule) !!}, {!! $campaign->getFilter(\App\Enums\CampaignFilterType::Timezone) !!}
        </span>
        
        <span>
            <h4 class="m-0 text-lg">{{ __('campaigns/applications.fields.player_count') }}</h4>
            <p>Current players: {{$campaign->users()->count() }}</p>
            <p>Max players: {{ $campaign->getFilter(\App\Enums\CampaignFilterType::PlayerCount)}}</p>
        </span>

        <br/>
        @guest
            <a href="{{ route('register', ['next' => 'dashboard', 'campaign' => $campaign->slug]) }}" class="btn2 btn-block btn-primary">
                <x-icon class="fa-regular fa-door-open" />
                {{ __('dashboards/widgets/join.register') }}
            </a>
        @endguest
        @can('apply', $campaign)
            <button id="campaign-apply" class="btn2 btn-block btn-primary" data-id="{{ $campaign->id }}"
                    data-url="{{ route('campaign.apply', $campaign) }}"
                    data-toggle="dialog" data-title="{{ __('dashboard.helpers.join') }}"
                    data-target="apply-dialog"
                    data-placement="bottom"
            >
                <x-icon class="fa-regular fa-door-open" />
                @if(auth()->user()->applications()->where('campaign_id', $campaign->id)->exists())
                    {{ __('dashboards/widgets/join.update') }}
                @else
                    {{ __('dashboards/widgets/join.apply') }}
                @endif

            </button>
        @endcan
    </div>
</x-box>

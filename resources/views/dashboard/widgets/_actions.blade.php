@can ('follow', $campaign)
    <button id="campaign-follow" class="btn2 btn-sm hidden" data-id="{{ $campaign->id }}"
            data-following="{{ $campaign->isFollowing() ? true : false }}"
            data-follow="{{ __('dashboard.actions.follow') }}"
            data-unfollow="{{ __('dashboard.actions.unfollow') }}"
            data-url="{{ route('campaign.follow', $campaign) }}"
            data-toggle="tooltip" data-title="{{ __('dashboard.helpers.follow') }}"
            data-placement="bottom"
    >
        <x-icon class="fa-solid fa-star" />
        <span id="campaign-follow-text"></span>
    </button>
@endcan
@can('apply', $campaign)
    <button id="campaign-apply" class="btn2 btn-sm" data-id="{{ $campaign->id }}"
            data-url="{{ route('campaign.apply', $campaign) }}"
            data-toggle="dialog-ajax" data-title="{{ __('dashboard.helpers.join') }}"
            data-target="apply-dialog"
            data-placement="bottom"
    >
        <x-icon class="fa-solid fa-door-open" />
        {{ __('dashboard.actions.join') }}
    </button>
@endcan

@cannot('update', $campaign)
    @if(!empty($dashboards))
        <div class="dropdown ">
            <button type="button" class="btn2 btn-sm" data-dropdown aria-expanded="false">
                <x-icon class="fa-solid fa-th-large" />
            </button>
            <div class="dropdown-menu hidden" role="menu">
                @if (!empty($dashboard))
                    <a href="{{ route('dashboard', [$campaign, 'dashboard' => 'default']) }}">
                        {{ __('dashboard.dashboards.default.title')}}
                    </a>
                @endif
                @foreach ($dashboards as $dash)
                    @if (!empty($dashboard) && $dash->id == $dashboard->id)
                        @continue
                    @endif
                    <x-dropdowns.item :link="route('dashboard', [$campaign, 'dashboard' => $dash->id])">
                        {!! $dash->name !!}
                    </x-dropdowns.item>
                @endforeach

                @can('dashboard', $campaign)
                    <hr class="m-0">

                    <a href="{{ route('dashboard.setup', !empty($dashboard) ? [$campaign, 'dashboard' => $dashboard->id] : [$campaign]) }}">
                        {{ __('dashboard.settings.title') }}
                    </a>
                @endcan
            </div>
        </div>
    @else
        @can('dashboard', $campaign)
            <a href="{{ route('dashboard.setup', $campaign) }}" class="btn2" title="{{ __('dashboard.settings.title') }}">
                <i class="fa-solid fa-th-large"></i>
            </a>
        @endcan
    @endif
@endcannot

@can('update', $campaign)
    <div class="dropdown">
        <button class="btn2 btn-sm" data-dropdown aria-expanded="false">
            <x-icon class="fa-solid fa-ellipsis-h" />

        </button>
        <div class="dropdown-menu hidden" role="menu">
            @if (!empty($dashboard))
                <x-dropdowns.item :link="route('dashboard', [$campaign, 'dashboard' => 'default'])" icon="fa-solid fa-th-large">
                    {{ __('dashboard.dashboards.default.title')}}
                </x-dropdowns.item>
            @endif
            @foreach ($dashboards as $dash)
                @if (!empty($dashboard) && $dash->id == $dashboard->id)
                    @continue
                @endif
                <x-dropdowns.item :link="route('dashboard', [$campaign, 'dashboard' => $dash->id])" icon="fa-solid fa-th-large">
                    {!! $dash->name !!}
                </x-dropdowns.item>
            @endforeach
            <x-dropdowns.item :link="route('dashboard.setup', !empty($dashboard) ? [$campaign, 'dashboard' => $dashboard->id] : [$campaign])" icon="cog">
                {{ __('dashboard.settings.title') }}
            </x-dropdowns.item>
            <hr class="m-0" />

            <x-dropdowns.item :link="route('campaigns.edit', $campaign)" icon="pencil">
                {{ __('campaigns.show.actions.edit') }}
            </x-dropdowns.item>

            <hr class="m-0" />
            <x-dropdowns.item :link="route('campaign_users.index', $campaign)" icon="fa-solid fa-users">
                {{ __('campaigns.show.tabs.members') }}
            </x-dropdowns.item>
            <x-dropdowns.item :link="route('campaign_roles.index', $campaign)" icon="fa-solid fa-screen-users">
                {{ __('campaigns.show.tabs.roles') }}
            </x-dropdowns.item>

            <x-dropdowns.item :link="route('campaign.modules', $campaign)" icon="fa-solid fa-floppy-disks">
                {{ __('sidebar.settings') }}
            </x-dropdowns.item>
        </div>
    </div>
@endcan

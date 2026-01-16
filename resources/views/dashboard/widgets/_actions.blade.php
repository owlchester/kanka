@can ('follow', $campaign)
    <button id="campaign-follow" class="btn2 btn-sm btn-outline hidden" data-id="{{ $campaign->id }}"
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
    <button id="campaign-apply" class="btn2 btn-sm btn-outline" data-id="{{ $campaign->id }}"
            data-url="{{ route('campaign.apply', $campaign) }}"
            data-toggle="dialog" data-title="{{ __('dashboard.helpers.join') }}"
            data-target="apply-dialog"
            data-placement="bottom"
    >
        <x-icon class="fa-regular fa-door-open" />
        {{ __('dashboard.actions.join') }}
    </button>
@endcan

@cannot('update', $campaign)
    @if(!empty($dashboards))
        <div class="dropdown ">
            <button type="button" class="btn2 btn-sm btn-outline" data-dropdown aria-expanded="false">
                <x-icon class="fa-regular fa-th-large" />
            </button>
            <div class="dropdown-menu hidden" role="menu">
                @if (!empty($dashboard))
                    <x-dropdowns.item :link="route('dashboard', [$campaign, 'dashboard' => 'default'])" icon="fa-regular fa-home">
                        {{ __('dashboard.dashboards.default.title')}}
                    </x-dropdowns.item>
                @endif
                @foreach ($dashboards as $dash)
                    @if (!empty($dashboard) && $dash->id == $dashboard->id)
                        @continue
                    @endif
                    <x-dropdowns.item :link="route('dashboard', [$campaign, 'dashboard' => $dash->id])" icon="fa-regular fa-th-large">
                        {!! $dash->name !!}
                    </x-dropdowns.item>
                @endforeach

                @can('dashboard', $campaign)
                    <x-dropdowns.divider />

                    <x-dropdowns.item :link="route('dashboard.setup', !empty($dashboard) ? [$campaign, 'dashboard' => $dashboard->id] : [$campaign])" icon="cog">
                        {{ __('dashboard.actions.customise') }}
                    </x-dropdowns.item>
                @endcan
            </div>
        </div>
    @else
        @can('dashboard', $campaign)
            <a href="{{ route('dashboard.setup', [$campaign]) }}" class="btn2 btn-sm btn-outline">
                <x-icon class="cog" /> {{ __('dashboard.actions.customise') }}
            </a>
        @endcan
    @endif
@endcannot

@can('update', $campaign)
    <div class="dropdown">
        <button class="btn2 btn-sm btn-outline" data-dropdown aria-expanded="false">
            <x-icon class="fa-regular fa-ellipsis-h" />
        </button>
        <div class="dropdown-menu hidden" role="menu">

            <x-dropdowns.section>
                @if ($dashboard)
                    {!! $dashboard->name !!}
                @else
                    {{ __('dashboard.dashboards.default.title') }}
                @endif
            </x-dropdowns.section>

            <x-dropdowns.item :link="route('dashboard.setup', !empty($dashboard) ? [$campaign, 'dashboard' => $dashboard->id] : [$campaign])" icon="cog">
                {{ __('dashboard.actions.customise') }}
            </x-dropdowns.item>

            @if (!empty($dashboard) || !empty($dashboards))
            <x-dropdowns.section>
                {{ __('dashboards/setup.sections.switch') }}
            </x-dropdowns.section>
            @endif
            @if (!empty($dashboard))
                <x-dropdowns.item :link="route('dashboard', [$campaign, 'dashboard' => 'default'])" icon="fa-regular fa-home">
                    {{ __('dashboard.dashboards.default.title')}}
                </x-dropdowns.item>
            @endif
            @foreach ($dashboards as $dash)
                @if (!empty($dashboard) && $dash->id == $dashboard->id)
                    @continue
                @endif
                <x-dropdowns.item :link="route('dashboard', [$campaign, 'dashboard' => $dash->id])" icon="fa-regular fa-th-large">
                    {!! $dash->name !!}
                </x-dropdowns.item>
            @endforeach

            <x-dropdowns.section>
                {{ __('dashboards/setup.sections.settings') }}
            </x-dropdowns.section>

            <x-dropdowns.item :link="route('campaigns.edit', $campaign)" icon="pencil">
                {{ __('campaigns.show.actions.edit') }}
            </x-dropdowns.item>

            <x-dropdowns.item :link="route('campaign_users.index', $campaign)" icon="fa-regular fa-users">
                {{ __('campaigns.show.tabs.members') }}
            </x-dropdowns.item>
            <x-dropdowns.item :link="route('campaign_roles.index', $campaign)" icon="fa-regular fa-user-shield">
                {{ __('campaigns.show.tabs.roles') }}
            </x-dropdowns.item>

            <x-dropdowns.item :link="route('campaign.modules', $campaign)" icon="fa-regular fa-floppy-disks">
                {{ __('campaigns.show.tabs.modules') }}
            </x-dropdowns.item>
        </div>
    </div>
@endcan

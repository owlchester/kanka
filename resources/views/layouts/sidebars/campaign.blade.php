@inject('sidebar', 'App\Services\SidebarService')
<aside class="main-sidebar main-sidebar-placeholder t-0 l-0 absolute @if(auth()->check() && $campaign->userIsMember())main-sidebar-member @else main-sidebar-public @endif" @if ($campaign->image) style="--sidebar-placeholder: url({{ Img::crop(240, 210)->url($campaign->image) }})" @endif>

    @include('layouts.sidebars._campaign')

    <section class="sidebar pb-14" style="height: auto">
        <ul class="sidebar-menu overflow-hidden whitespace-no-wrap list-none m-0 p-0">
            <li class="px-2 section-dashboard">
                <x-sidebar.element
                    :url="route('dashboard', [$campaign])"
                    icon="fa-duotone fa-house"
                    :text="__('sidebar.dashboard')"
                ></x-sidebar.element>
            </li>
            <li class="px-2 section-overview {{ $sidebar->activeCampaign('overview') }}">
                <x-sidebar.element
                    :url="route('overview', [$campaign])"
                    icon="fa-duotone fa-block"
                    :text="__('crud.tabs.overview')"
                ></x-sidebar.element>


                <ul class="sidebar-submenu list-none p-0 pl-4 m-0">
                    @can('update', $campaign)
                        <li class="px-2 section-overview {{ $sidebar->activeCampaign('recovery') }}">
                            <x-sidebar.element
                                :url="route('recovery', [$campaign])"
                                icon="fa-duotone fa-trash-undo"
                                :text="__('campaigns.show.tabs.recovery')"
                            ></x-sidebar.element>
                        </li>
                    @endcan
                    <li class="px-2 section-overview {{ $sidebar->activeCampaign('achievements') }}">
                        <x-sidebar.element
                            :url="route('stats', [$campaign])"
                            icon="fa-duotone fa-bars-progress"
                            :text="__('campaigns.show.tabs.achievements')"
                        ></x-sidebar.element>
                    </li>
                </ul>
            </li>
            @if (auth()->check() && (auth()->user()->can('members', $campaign) || auth()->user()->can('submissions', $campaign) || auth()->user()->can('roles', $campaign)))
            <li class="px-2 section-management">
                <x-sidebar.element
                    icon="fa-duotone fa-person-sign"
                    :text="__('campaigns.show.tabs.management')"
                ></x-sidebar.element>

                <ul class="sidebar-submenu list-none p-0 pl-4 m-0">
                @can('members', $campaign)
                <li class="px-2 section-members {{ $sidebar->activeCampaign('campaign_users') }}">
                    <x-sidebar.element
                        :url="route('campaign_users.index', [$campaign])"
                        icon="fa-duotone fa-users"
                        :text="__('campaigns.show.tabs.members')"
                    ></x-sidebar.element>
                </li>
                @endif
                @can('roles', $campaign)
                    <li class="px-2 section-roles {{ $sidebar->activeCampaign('campaign_roles') }}">
                        <x-sidebar.element
                            :url="route('campaign_roles.index', [$campaign])"
                            icon="fa-duotone fa-screen-users"
                            :text="__('campaigns.show.tabs.roles')"
                        ></x-sidebar.element>
                    </li>
                @endif
                @can('submissions', $campaign)
                    <li class="px-2 section-submissions {{ $sidebar->activeCampaign('campaign_submissions') }}">
                        <x-sidebar.element
                            :url="route('campaign_submissions.index', [$campaign])"
                            icon="fa-duotone fa-arrow-right-to-bracket"
                            :text="__('campaigns.show.tabs.applications')"
                        ></x-sidebar.element>
                    </li>
                @endif
                </ul>
            </li>
            @endif

            <li class="px-2 section-customisation">
                <x-sidebar.element
                    icon="fa-duotone fa-cog"
                    :text="__('campaigns.show.tabs.customisation')"
                ></x-sidebar.element>
                <ul class="sidebar-submenu list-none p-0 pl-4 m-0">

                    <li class="px-2 section-modules {{ $sidebar->activeCampaign('modules') }}">
                        <x-sidebar.element
                            :url="route('campaign.modules', [$campaign])"
                            icon="fa-duotone fa-floppy-disks"
                            :text="__('campaigns.show.tabs.modules')"
                        ></x-sidebar.element>
                    </li>
                    @if(config('marketplace.enabled'))
                        <li class="px-2 section-modules {{ $sidebar->activeCampaign('plugins') }}">
                            <x-sidebar.element
                                :url="route('campaign_plugins.index', [$campaign])"
                                icon="fa-duotone fa-shop"
                                :text="__('campaigns.show.tabs.plugins')"
                            ></x-sidebar.element>
                        </li>
                    @endif
                    <li class="px-2 section-modules {{ $sidebar->activeCampaign('default-images') }}">
                        <x-sidebar.element
                            :url="route('campaign.default-images', [$campaign])"
                            icon="fa-duotone fa-image"
                            :text="__('campaigns.show.tabs.default-images')"
                        ></x-sidebar.element>
                    </li>

                    @can('update', $campaign)
                    <li class="px-2 section-modules {{ $sidebar->activeCampaign('campaign_styles') }}">
                        <x-sidebar.element
                            :url="route('campaign_styles.index', [$campaign])"
                            icon="fa-duotone fa-palette"
                            :text="__('campaigns.show.tabs.styles')"
                        ></x-sidebar.element>
                    </li>
                        <li class="px-2 section-modules {{ $sidebar->activeCampaign('sidebar-setup') }}">
                            <x-sidebar.element
                                :url="route('campaign-sidebar', [$campaign])"
                                icon="fa-duotone fa-bars-staggered"
                                :text="__('campaigns.show.tabs.sidebar')"
                            ></x-sidebar.element>
                        </li>
                    @endif
                </ul>
            </li>


            @can('update', $campaign)
            <li class="px-2 section-management">
                <x-sidebar.element
                    icon="fa-duotone fa-database"
                    :text="__('campaigns.show.tabs.data')"
                ></x-sidebar.element>
                <ul class="sidebar-submenu list-none p-0 pl-4 m-0">
                    <li class="px-2 section-overview {{ $sidebar->activeCampaign('campaign-export') }}">
                        <x-sidebar.element
                            :url="route('campaign.export', [$campaign])"
                            icon="fa-duotone fa-download"
                            :text="__('campaigns.show.tabs.export')"
                        ></x-sidebar.element>
                    </li>
                    <li class="px-2 section-overview {{ $sidebar->activeCampaign('campaign-import') }}">
                        <x-sidebar.element
                            :url="route('campaign.import', [$campaign])"
                            icon="fa-duotone fa-upload"
                            :text="__('campaigns.show.tabs.import')"
                        ></x-sidebar.element>
                    </li>
                    @can('webhooks', $campaign)
                        <li class="px-2 section-webhooks {{ $sidebar->activeCampaign('webhooks') }}">
                            <x-sidebar.element
                                :url="route('webhooks.index', [$campaign])"
                                icon="fa-duotone fa-webhook"
                                :text="__('campaigns.show.tabs.webhooks')"
                            ></x-sidebar.element>
                        </li>
                    @endif
                </ul>
            </li>
            @endif
        </ul>
    </section>
</aside>

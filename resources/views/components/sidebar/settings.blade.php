@php /** @var \App\Models\Campaign $campaign */ @endphp
<aside class="main-sidebar main-sidebar-placeholder z-20 h-auto min-h-full absolute flex flex-col @if(auth()->check() && $campaign->userIsMember())main-sidebar-member @else main-sidebar-public @endif" @if ($campaign->image) style="--sidebar-placeholder: url({{ Img::crop(240, 208)->url($campaign->image) }})" @endif>
    @include('layouts.sidebars._campaign')

    <section class="sidebar grow">
        <ul class="sidebar-menu overflow-hidden whitespace-no-wrap list-none m-0 p-0">
            <li class="px-2 section-dashboard">
                <x-sidebar.element
                    :url="route('dashboard', [$campaign])"
                    icon="fa-duotone fa-house"
                    :text="__('sidebar.dashboard')"
                ></x-sidebar.element>
            </li>
            <li class="px-2 section-overview {{ $active('overview') }}">
                <x-sidebar.element
                    :url="route('overview', [$campaign])"
                    icon="fa-duotone fa-block"
                    :text="__('crud.tabs.overview')"
                ></x-sidebar.element>
            </li>
            @can('update', $campaign)
                <li class="px-2 section-overview {{ $active('recovery') }}">
                    <x-sidebar.element
                        :url="route('recovery', [$campaign])"
                        icon="fa-duotone fa-trash-undo"
                        :text="__('campaigns.show.tabs.recovery')"
                        premium
                    ></x-sidebar.element>
                </li>
            @endcan
            <li class="px-2 section-overview {{ $active('achievements') }}">
                <x-sidebar.element
                    :url="route('campaign.achievements', [$campaign])"
                    icon="fa-duotone fa-bars-progress"
                    :text="__('campaigns.show.tabs.achievements')"
                    premium
                ></x-sidebar.element>
            </li>
            <li class="px-2 section-overview {{ $active('stats') }}">
                <x-sidebar.element
                    :url="route('campaign.stats', [$campaign])"
                    icon="fa-duotone fa-bars"
                    :text="__('campaigns.show.tabs.stats')"
                ></x-sidebar.element>
            </li>
            @if (auth()->check() && (auth()->user()->can('members', $campaign) || auth()->user()->can('applications', $campaign) || auth()->user()->can('roles', $campaign)))
                <li class="section-management pt-4">
                    <x-sidebar.section :text="__('campaigns.show.tabs.management')" />
                    <ul class="sidebar-submenu list-none p-0 m-0">
                        @can('members', $campaign)
                            <li class="px-2 section-members {{ $active('campaign_users') }}">
                                <x-sidebar.element
                                    :url="route('campaign_users.index', [$campaign])"
                                    icon="fa-duotone fa-users"
                                    :text="__('campaigns.show.tabs.members')"
                                ></x-sidebar.element>
                            </li>
                        @endif
                        @can('roles', $campaign)
                            <li class="px-2 section-roles {{ $active('campaign_roles') }}">
                                <x-sidebar.element
                                    :url="route('campaign_roles.index', [$campaign])"
                                    icon="fa-duotone fa-screen-users"
                                    :text="__('campaigns.show.tabs.roles')"
                                ></x-sidebar.element>
                            </li>
                        @endif
                        @can('applications', $campaign)
                            <li class="px-2 section-applications {{ $active('applications') }}">
                                <x-sidebar.element
                                    :url="route('applications.index', [$campaign])"
                                    icon="fa-duotone fa-arrow-right-to-bracket"
                                    :text="__('campaigns.show.tabs.applications')"
                                ></x-sidebar.element>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            <li class="section-customisation pt-4">
                <x-sidebar.section :text="__('campaigns.show.tabs.customisation')" />
                <ul class="sidebar-submenu list-none p-0 m-0">

                    @can('setting', $campaign)
                        <li class="px-2 section-modules {{ $active(['modules', 'entity_types']) }}">
                            <x-sidebar.element
                                :url="route('campaign.modules', [$campaign])"
                                icon="fa-duotone fa-floppy-disks"
                                :text="__('campaigns.show.tabs.modules')"
                            ></x-sidebar.element>
                        </li>
                    @endcan
                    @if(config('marketplace.enabled'))
                        <li class="px-2 section-modules {{ $active('plugins') }}">
                            <x-sidebar.element
                                :url="route('campaign_plugins.index', [$campaign])"
                                icon="fa-duotone fa-shop"
                                :text="__('campaigns.show.tabs.plugins')"
                                premium
                            ></x-sidebar.element>
                        </li>
                    @endif
                    <li class="px-2 section-modules {{ $active('default-images') }}">
                        <x-sidebar.element
                            :url="route('campaign.default-images', [$campaign])"
                            icon="fa-duotone fa-image"
                            :text="__('campaigns.show.tabs.default-images')"
                            premium
                        ></x-sidebar.element>
                    </li>

                    @can('update', $campaign)
                        <li class="px-2 section-modules {{ $active(['campaign_styles', 'theme-builder']) }}">
                            <x-sidebar.element
                                :url="route('campaign_styles.index', [$campaign])"
                                icon="fa-duotone fa-palette"
                                :text="__('campaigns.show.tabs.styles')"
                                premium
                            ></x-sidebar.element>
                        </li>
                        <li class="px-2 section-modules {{ $active('sidebar-setup') }}">
                            <x-sidebar.element
                                :url="route('campaign-sidebar', [$campaign])"
                                icon="fa-duotone fa-bars-staggered"
                                :text="__('campaigns.show.tabs.sidebar')"
                                premium
                            ></x-sidebar.element>
                        </li>
                    @endif
                </ul>
            </li>

            @can('update', $campaign)
                <li class="section-management pt-4">
                    <x-sidebar.section :text="__('campaigns.show.tabs.data')" />
                    <ul class="sidebar-submenu list-none p-0 m-0">
                        <li class="px-2 section-overview {{ $active('campaign-export') }}">
                            <x-sidebar.element
                                :url="route('campaign.export', [$campaign])"
                                icon="fa-duotone fa-download"
                                :text="__('campaigns.show.tabs.export')"
                            ></x-sidebar.element>
                        </li>
                        <li class="px-2 section-overview {{ $active('campaign-import') }}">
                            <x-sidebar.element
                                :url="route('campaign.import', [$campaign])"
                                icon="fa-duotone fa-upload"
                                :text="__('campaigns.show.tabs.import')"
                            ></x-sidebar.element>
                        </li>
                        @can('webhooks', $campaign)
                            <li class="px-2 section-webhooks {{ $active('webhooks') }}">
                                <x-sidebar.element
                                    :url="route('webhooks.index', [$campaign])"
                                    icon="fa-duotone fa-webhook"
                                    :text="__('campaigns.show.tabs.webhooks')"
                                    premium
                                ></x-sidebar.element>
                            </li>
                        @endif
                        @can('apiKeys', $campaign)
                            <li class="px-2 section-api-keys {{ $active('api-keys') }}">
                                <x-sidebar.element
                                    :url="route('api-keys.index', [$campaign])"
                                    icon="fa-duotone fa-webhook"
                                    :text="__('campaigns.show.tabs.api-keys')"
                                    premium
                                ></x-sidebar.element>
                            </li>
                        @endif
                        @can('logs', $campaign)
                            <li class="px-2 section-webhooks {{ $active('logs') }}">
                                <x-sidebar.element
                                    :url="route('campaign.logs', [$campaign])"
                                    icon="fa-duotone fa-timeline"
                                    :text="__('campaigns.show.tabs.logs')"
                                ></x-sidebar.element>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            @can('roles', $campaign)
                <li class="section-management pt-4">
                    <x-sidebar.section :text="__('campaigns.show.tabs.danger')" />
                    <ul class="sidebar-submenu list-none p-0 m-0">
                        <li class="px-2 section-overview {{ $active('deletion') }}">
                            <x-sidebar.element
                                :url="route('campaign.delete', [$campaign])"
                                icon="fa-duotone fa-radiation"
                                :text="__('campaigns.show.tabs.deletion')"
                            ></x-sidebar.element>
                        </li>
                    </ul>
                </li>
            @endcan
        </ul>
    </section>
</aside>

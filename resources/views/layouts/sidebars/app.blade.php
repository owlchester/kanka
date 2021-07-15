<?php
/**
 * @var \App\Models\Campaign $currentCampaign
 * @var \App\Models\Campaign $campaign
 */
$currentCampaign = CampaignLocalization::getCampaign();
$defaultIndex = auth()->check() && auth()->user()->defaultNested ? 'tree' : 'index';
?>
@if (!empty($currentCampaign))
    @php \App\Facades\Dashboard::campaign($currentCampaign); @endphp
    @inject('sidebar', 'App\Services\SidebarService')
    @inject('campaign', 'App\Services\CampaignService')
    <aside class="main-sidebar main-sidebar-placeholder @if(auth()->check() && $currentCampaign->userIsMember())main-sidebar-member @else main-sidebar-public @endif" @if ($currentCampaign->image) style="background-image: url({{ Img::crop(280, 210)->url($currentCampaign->image) }})" @endif>
        <section class="sidebar-campaign">
            <div class="campaign-block">
                <div class="campaign-head">
                    <div class="campaign-name" data-toggle="collapse" data-target="#campaign-switcher">
                        <i class="fa fa-caret-down pull-right"></i>
                        {!! $currentCampaign->name !!}
                    </div>

                    <div class="campaign-updated">
                        {{ __('sidebar.campaign_switcher.updated') }} {{ $currentCampaign->updated_at->diffForHumans() }}
                    </div>
                </div>
            </div>
        </section>

        @include('layouts.sidebars.campaign-switcher')

        <section class="sidebar" style="height: auto">
            <ul class="sidebar-menu tree" data-widget="tree">
                <li class="{{ $sidebar->active('dashboard') }} section section-dashboard">
                    <a href="{{ route('dashboard') }}">
                        <i class="fas fa-th-large"></i> <span>{{ __('sidebar.dashboard') }}</span>
                    </a>
                </li>
                @if ($campaign->enabled('menu_links'))
                    <li class="{{ $sidebar->open('menu_links') }} sidebar-section sidebar-quick-links">
                        <div class="sidebar-text">
                            <i class="fa fa-star"></i>
                            <span>{{ __('entities.menu_links') }}</span>

                            @if(Auth::check() && Auth::user()->isAdmin())
                                <a href="{{ route('menu_links.index') }}" class="pull-right sidebar-icon-link">
                                    <i class="fas fa-cog"></i>
                                </a>
                            @endif
                        </div>
                    </li>
                    @foreach ($currentCampaign->menuLinks()->with(['target'])->ordered()->get() as $menuLink)
                        <?php /** @var \App\Models\MenuLink $menuLink */ ?>
                        @if ($menuLink->dashboard && $currentCampaign->boosted() && $menuLink->isValidDashboard())
                            <li class="subsection sidebar-quick-link sidebar-quick-link-{{ $menuLink->position }} {{ $sidebar->activeMenuLink($menuLink) }}">
                                <a href="{{ $menuLink->getRoute() }}">
                                    <i class="{{ $menuLink->icon() }}"></i> <span>{{ $menuLink->name }}</span>
                                </a>
                            </li>
                        @elseif ($menuLink->target)
                            <li class="subsection sidebar-quick-link sidebar-quick-link-{{ $menuLink->position }} {{ $sidebar->activeMenuLink($menuLink) }}">
                                <a href="{{ $menuLink->getRoute() }}">
                                    <i class="{{ $menuLink->icon() }}"></i> <span>{{ $menuLink->name }}</span>
                                </a>
                            </li>
                        @elseif ($menuLink->type)
                            <li class="subsection sidebar-quick-link sidebar-quick-link-{{ $menuLink->position }} {{ $sidebar->activeMenuLink($menuLink) }}">
                                <a href="{{ $menuLink->getRoute() }}">
                                    <i class="{{ $menuLink->icon() }}"></i> <span>{{ $menuLink->name }}</span>
                                </a>
                            </li>
                        @elseif ($menuLink->isRandom())
                            <li class="subsection sidebar-quick-link sidebar-quick-link-{{ $menuLink->position }} {{ $sidebar->activeMenuLink($menuLink) }}">
                                <a href="{{ route('menu_links.random', $menuLink) }}">
                                    <i class="{{ $menuLink->icon() }}"></i> <span>{{ $menuLink->name }}</span>
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif

                <li class="{{ $sidebar->active('campaigns') }} section section-world">
                    <a href="{{ route('campaign') }}">
                        <i class="fa fa-globe"></i>
                        <span>{{ __('sidebar.world') }}</span>
                    </a>
                </li>

                @if ($campaign->enabled('characters'))
                    <li class="{{ $sidebar->active('characters') }} subsection section-characters">
                        <a href="{{ route('characters.index') }}"><i class="fa fa-user"></i> <span>{{ __('sidebar.characters') }}</span></a>
                    </li>
                @endif
                @if ($campaign->enabled('locations'))
                    <li class="{{ $sidebar->active('locations') }} subsection  section-locations">
                        <a href="{{ route('locations.' . $defaultIndex) }}"><i class="ra ra-tower"></i> <span>{{ __('sidebar.locations') }}</span></a>
                    </li>
                @endif
                @if ($campaign->enabled('maps'))
                    <li class="{{ $sidebar->active('maps') }} subsection section-maps">
                        <a href="{{ route('maps.' . $defaultIndex) }}"><i class="fas fa-map"></i> <span>{{ __('entities.maps') }}</span></a>
                    </li>
                @endif
                @if ($campaign->enabled('organisations'))
                    <li class="{{ $sidebar->active('organisations') }} subsection section-organisations">
                        <a href="{{ route('organisations.' . $defaultIndex) }}"><i class="ra ra-hood"></i> <span>{{ __('sidebar.organisations') }}</span></a>
                    </li>
                @endif
                @if ($campaign->enabled('families'))
                    <li class="{{ $sidebar->active('families') }} subsection section-families">
                        <a href="{{ route('families.' . $defaultIndex) }}"><i class="ra ra-double-team"></i> <span>{{ __('sidebar.families') }}</span></a>
                    </li>
                @endif
                @if ($campaign->enabled('calendars'))
                    <li class="{{ $sidebar->active('calendars') }} subsection section-calendars">
                        <a href="{{ route('calendars.' . $defaultIndex) }}"><i class="fa fa-calendar"></i> <span>{{ __('sidebar.calendars') }}</span></a>
                    </li>
                @endif
                @if ($campaign->enabled('timelines'))
                    <li class="{{ $sidebar->active('timelines') }} subsection section-timelines">
                        <a href="{{ route('timelines.' . $defaultIndex) }}"><i class="fas fa-hourglass-half"></i> <span>{{ __('sidebar.timelines') }}</span></a>
                    </li>
                @endif
                @if ($campaign->enabled('races'))
                    <li class="{{ $sidebar->active('races') }} subsection section-races">
                        <a href="{{ route('races.' . $defaultIndex) }}"><i class="ra ra-wyvern"></i> <span>{{ __('sidebar.races') }}</span></a>
                    </li>
                @endif

                <li class="section section-campaign">
                    <a href="{{ route('campaign') }}">
                        <i class="fa fa-globe"></i>
                        <span>{{ __('sidebar.campaign') }}</span>
                    </a>
                </li>
                @if ($campaign->enabled('quests'))
                    <li class="{{ $sidebar->active('quests') }} subsection section-quests">
                        <a href="{{ route('quests.' . $defaultIndex) }}"><i class="ra ra-wooden-sign"></i> <span>{{ __('sidebar.quests') }}</span></a>
                    </li>
                @endif
                @if ($campaign->enabled('journals'))
                    <li class="{{ $sidebar->active('journals') }} subsection section-journals">
                        <a href="{{ route('journals.' . $defaultIndex) }}"><i class="ra ra-quill-ink"></i> <span>{{ __('sidebar.journals') }}</span></a>
                    </li>
                @endif

                @if ($campaign->enabled('items'))
                    <li class="{{ $sidebar->active('items') }} subsection section-items">
                        <a href="{{ route('items.index') }}"><i class="ra ra-gem-pendant"></i> <span>{{ __('sidebar.items') }}</span></a>
                    </li>
                @endif
                @if ($campaign->enabled('events'))
                    <li class="{{ $sidebar->active('events') }} subsection section-events">
                        <a href="{{ route('events.' . $defaultIndex) }}"><i class="fa fa-bolt"></i> <span>{{ __('sidebar.events') }}</span></a>
                    </li>
                @endif
                @if ($campaign->enabled('abilities'))
                    <li class="{{ $sidebar->active('abilities') }} subsection section-abilities">
                        <a href="{{ route('abilities.' . $defaultIndex) }}"><i class="ra ra-fire-symbol"></i> <span>{{ __('sidebar.abilities') }}</span></a>
                    </li>
                @endif


                @if ($campaign->enabled('notes'))
                    <li class="{{ $sidebar->active('notes') }} section-notes">
                        <a href="{{ route('notes.' . $defaultIndex) }}"><i class="fas fa-book-open"></i> <span>{{ __('sidebar.notes') }}</span></a>
                    </li>
                @endif

                <li class="sidebar-section section-other">
                    <div class="sidebar-text">
                        <i class="fas fa-cubes"></i>
                        <span>{{ __('sidebar.other') }}</span>
                    </div>
                </li>

                @if ($campaign->enabled('tags'))
                    <li class="{{ $sidebar->active('tags') }} subsection section-tags">
                        <a href="{{ route('tags.' . $defaultIndex) }}"><i class="fa fa-tags"></i> <span>{{ __('sidebar.tags') }}</span></a>
                    </li>
                @endif
                @if ($campaign->enabled('conversations'))
                    <li class="{{ $sidebar->active('conversations') }} subsection section-conversations">
                        <a href="{{ route('conversations.index') }}"><i class="fa fa-comment"></i> <span>{{ __('sidebar.conversations') }}</span></a>
                    </li>
                @endif
                @if ($campaign->enabled('dice_rolls'))
                    <li class="{{ $sidebar->active('dice_rolls') }} subsection section-dice-rolls">
                        <a href="{{ route('dice_rolls.index') }}"><i class="ra ra-dice-five"></i> <span>{{ __('sidebar.dice_rolls') }}</span></a>
                    </li>
                @endif
                @can('gallery', $currentCampaign)
                    <li class="{{ $sidebar->active('gallery') }} subsection section-gallery">
                        <a href="{{ route('campaign.gallery.index') }}"><i class="fas fa-images"></i> <span>{{ __('sidebar.gallery') }}</span></a>
                    </li>
                @endcan
                <li class="{{ $sidebar->active('attribute_templates') }} subsection section-attribute-templates">
                    <a href="{{ route('attribute_templates.index') }}"><i class="fa fa-copy"></i> <span>{{ __('sidebar.attribute_templates') }}</span></a>
                </li>
            </ul>
        </section>
    </aside>
    @if (Auth::check() && $currentCampaign->userIsMember())
        <section class="sidebar-creator">
            <a href="#" data-url="{{ route('entity-creator.selection') }}" data-toggle="ajax-modal" data-target="#entity-modal" title="{{ __('entities.creator.title') }}">
                <i class="fa fa-plus"></i> <span>{{ __('sidebar.new-entity') }}</span>
            </a>
        </section>
    @endif
@elseif (Auth::check() && Auth::user()->hasCampaigns())
    <aside class="main-sidebar">
        <section class="sidebar">
            <ul class="sidebar-menu tree" data-widget="tree">
                @foreach (Auth::user()->campaigns as $campaign)
                    <li class="section-campaign section-campaign-{{ $campaign->id }}">
                        <a href="{{ url(App::getLocale() . '/' . $campaign->getMiddlewareLink()) }}"><i class="fa fa-globe"></i> <span>{!! $campaign->name !!}</span></a>
                    </li>
                @endforeach
            </ul>
        </section>
    </aside>
@endif

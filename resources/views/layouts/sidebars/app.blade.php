<?php
/**
 * @var \App\Models\Campaign $currentCampaign
 * @var \App\Models\Campaign $campaign
 */
$currentCampaign = CampaignLocalization::getCampaign();
$defaultIndex = auth()->check() && auth()->user()->defaultNested ? 'tree' : 'index';
?>
@if (!empty($currentCampaign))
    @inject('sidebar', 'App\Services\SidebarService')
    @inject('campaign', 'App\Services\CampaignService')
    <aside class="main-sidebar main-sidebar-placeholder" @if ($currentCampaign->image) style="background-image: url({{ Img::crop(280, 210)->url($currentCampaign->image) }})" @endif>
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
                <li class="{{ $sidebar->active('dashboard') }}">
                    <a href="{{ route('dashboard') }}">
                        <i class="fas fa-th-large"></i> <span>{{ trans('sidebar.dashboard') }}</span>
                    </a>
                </li>
                @if ($campaign->enabled('menu_links'))
                    <li class="{{ $sidebar->open('menu_links') }} sidebar-section sidebar-quick-links">
                        <div class="sidebar-text">
                            <i class="fa fa-star"></i>
                            <span>{{ trans('entities.menu_links') }}</span>

                            @if(Auth::check() && Auth::user()->isAdmin())
                                <a href="{{ route('menu_links.index') }}" class="pull-right sidebar-icon-link">
                                    <i class="fas fa-cog"></i>
                                </a>
                            @endif
                        </div>
                    </li>
                    @foreach ($currentCampaign->menuLinks()->with(['target'])->ordered()->get() as $menuLink)
                        <?php /** @var \App\Models\MenuLink $menuLink */ ?>
                        @if ($menuLink->target && $menuLink->target)
                            <li class="subsection sidebar-quick-link sidebar-quick-link-{{ $menuLink->position }}">
                                <a href="{{ $menuLink->getRoute() }}">
                                    <i class="fa fa-arrow-circle-right"></i> <span>{{ $menuLink->name }}</span>
                                </a>
                            </li>
                        @elseif ($menuLink->type)
                            <li class="subsection">
                                <a href="{{ $menuLink->getRoute() }}">
                                    <i class="fa fa-th-list"></i> <span>{{ $menuLink->name }}</span>
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif

                <li class="{{ $sidebar->active('campaigns') }}">
                    <a href="{{ (auth()->check() ? route('campaign') : '#') }}">
                        <i class="fa fa-globe"></i>
                        <span>{{ trans('sidebar.world') }}</span>
                    </a>
                </li>

                @if ($campaign->enabled('characters'))
                    <li class="{{ $sidebar->active('characters') }} subsection">
                        <a href="{{ route('characters.index') }}"><i class="fa fa-user"></i> <span>{{ trans('sidebar.characters') }}</span></a>
                    </li>
                @endif
                @if ($campaign->enabled('locations'))
                    <li class="{{ $sidebar->active('locations') }} subsection">
                        <a href="{{ route('locations.' . $defaultIndex) }}"><i class="ra ra-tower"></i> <span>{{ trans('sidebar.locations') }}</span></a>
                    </li>
                @endif
                @if ($campaign->enabled('maps'))
                    <li class="{{ $sidebar->active('maps') }} subsection">
                        <a href="{{ route('maps.' . $defaultIndex) }}"><i class="fas fa-map"></i> <span>{{ trans('entities.maps') }}</span></a>
                    </li>
                @endif
                @if ($campaign->enabled('organisations'))
                    <li class="{{ $sidebar->active('organisations') }} subsection">
                        <a href="{{ route('organisations.' . $defaultIndex) }}"><i class="ra ra-hood"></i> <span>{{ trans('sidebar.organisations') }}</span></a>
                    </li>
                @endif
                @if ($campaign->enabled('families'))
                    <li class="{{ $sidebar->active('families') }} subsection">
                        <a href="{{ route('families.' . $defaultIndex) }}"><i class="ra ra-double-team"></i> <span>{{ trans('sidebar.families') }}</span></a>
                    </li>
                @endif
                @if ($campaign->enabled('calendars'))
                    <li class="{{ $sidebar->active('calendars') }} subsection">
                        <a href="{{ route('calendars.index') }}"><i class="fa fa-calendar"></i> <span>{{ trans('sidebar.calendars') }}</span></a>
                    </li>
                @endif
                @if ($campaign->enabled('timelines'))
                    <li class="{{ $sidebar->active('timelines') }} subsection">
                        <a href="{{ route('timelines.index') }}"><i class="fas fa-hourglass-half"></i> <span>{{ trans('sidebar.timelines') }}</span></a>
                    </li>
                @endif
                @if ($campaign->enabled('races'))
                    <li class="{{ $sidebar->active('races') }} subsection">
                        <a href="{{ route('races.' . $defaultIndex) }}"><i class="ra ra-wyvern"></i> <span>{{ trans('sidebar.races') }}</span></a>
                    </li>
                @endif

                <li class="sidebar-section">
                    <a href="{{ (auth()->check() ? route('campaign') : '#') }}">
                        <i class="fa fa-globe"></i>
                        <span>{{ trans('sidebar.campaign') }}</span>
                    </a>
                </li>
                @if ($campaign->enabled('quests'))
                    <li class="{{ $sidebar->active('quests') }} subsection">
                        <a href="{{ route('quests.' . $defaultIndex) }}"><i class="ra ra-wooden-sign"></i> <span>{{ trans('sidebar.quests') }}</span></a>
                    </li>
                @endif
                @if ($campaign->enabled('journals'))
                    <li class="{{ $sidebar->active('journals') }} subsection">
                        <a href="{{ route('journals.' . $defaultIndex) }}"><i class="ra ra-quill-ink"></i> <span>{{ trans('sidebar.journals') }}</span></a>
                    </li>
                @endif

                @if ($campaign->enabled('items'))
                    <li class="{{ $sidebar->active('items') }} subsection">
                        <a href="{{ route('items.index') }}"><i class="ra ra-gem-pendant"></i> <span>{{ trans('sidebar.items') }}</span></a>
                    </li>
                @endif
                @if ($campaign->enabled('events'))
                    <li class="{{ $sidebar->active('events') }} subsection">
                        <a href="{{ route('events.index') }}"><i class="fa fa-bolt"></i> <span>{{ trans('sidebar.events') }}</span></a>
                    </li>
                @endif
                @if ($campaign->enabled('abilities'))
                    <li class="{{ $sidebar->active('abilities') }} subsection">
                        <a href="{{ route('abilities.' . $defaultIndex) }}"><i class="ra ra-fire-symbol"></i> <span>{{ trans('sidebar.abilities') }}</span></a>
                    </li>
                @endif



                @if ($campaign->enabled('notes'))
                    <li class="{{ $sidebar->active('notes') }}">
                        <a href="{{ route('notes.' . $defaultIndex) }}"><i class="fas fa-book-open"></i> <span>{{ trans('sidebar.notes') }}</span></a>
                    </li>
                @endif

                <li class="sidebar-section">
                    <div class="sidebar-text">
                        <i class="fas fa-cubes"></i>
                        <span>{{ trans('sidebar.other') }}</span>
                    </div>
                </li>

                @if ($campaign->enabled('tags'))
                    <li class="{{ $sidebar->active('tags') }} subsection">
                        <a href="{{ route('tags.' . $defaultIndex) }}"><i class="fa fa-tags"></i> <span>{{ trans('sidebar.tags') }}</span></a>
                    </li>
                @endif
                @if ($campaign->enabled('conversations'))
                    <li class="{{ $sidebar->active('conversations') }} subsection">
                        <a href="{{ route('conversations.index') }}"><i class="fa fa-comment"></i> <span>{{ trans('sidebar.conversations') }}</span></a>
                    </li>
                @endif
                @if ($campaign->enabled('dice_rolls'))
                    <li class="{{ $sidebar->active('dice_rolls') }} subsection">
                        <a href="{{ route('dice_rolls.index') }}"><i class="ra ra-dice-five"></i> <span>{{ trans('sidebar.dice_rolls') }}</span></a>
                    </li>
                @endif
                <li class="{{ $sidebar->active('attribute_templates') }} subsection">
                    <a href="{{ route('attribute_templates.index') }}"><i class="fa fa-copy"></i> <span>{{ trans('sidebar.attribute_templates') }}</span></a>
                </li>
            </ul>
        </section>
    </aside>
    @if (Auth::check() && $currentCampaign->userIsMember())
        <section class="sidebar-creator">
            <a href="#" data-url="{{ route('entity-creator.selection') }}" data-toggle="ajax-modal" data-target="#entity-modal" title="{{ __('entities.creator.title') }}">
                <i class="fa fa-plus"></i> <span>{{ trans('sidebar.new-entity') }}</span>
            </a>
        </section>
    @endif
@elseif (Auth::check() && Auth::user()->hasCampaigns())
    <aside class="main-sidebar">
        <section class="sidebar">
            <ul class="sidebar-menu tree" data-widget="tree">
                @foreach (Auth::user()->campaigns as $campaign)
                    <li class="">
                        <a href="{{ url(App::getLocale() . '/' . $campaign->getMiddlewareLink()) }}"><i class="fa fa-globe"></i> <span>{!! $campaign->name !!}</span></a>
                    </li>
                @endforeach
            </ul>
        </section>
    </aside>
@endif

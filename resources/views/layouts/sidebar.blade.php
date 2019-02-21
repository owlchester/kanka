<?php $currentCampaign = CampaignLocalization::getCampaign();
$defaultIndex = auth()->check() && auth()->user()->defaultNested ? 'tree' : 'index';
?>
@if (!empty($currentCampaign))
    @inject('sidebar', 'App\Services\SidebarService')
    @inject('campaign', 'App\Services\CampaignService')
<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu tree" data-widget="tree">
            <li class="{{ $sidebar->active('dashboard') }}">
                <a href="{{ route('dashboard') }}">
                    <i class="fas fa-th-large"></i> <span>{{ trans('sidebar.dashboard') }}</span>
                </a>
            </li>
            @if (Auth::check())
            <li class="{{ $sidebar->active('campaigns') }}">
                <a href="{{ route('campaign') }}"><i class="fa fa-globe"></i> <span>{{ trans('sidebar.campaign') }}</span></a>
            </li>
            @endif
            @if ($campaign->enabled('menu_links'))
            <li class="treeview {{ $sidebar->open('menu_links') }}">
                <a href="#">
                    <i class="fa fa-link"></i>
                    <span>{{ trans('sidebar.custom_links') }}</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu" style="{{ ($sidebar->open('menu_links') == 'menu-open' ? 'display:block' : 'display:none') }}">
                    @foreach ($currentCampaign->menuLinks()->with(['target'])->orderBy('name', 'ASC')->get() as $menuLink)
                        <?php /** @var \App\Models\MenuLink $menuLink */ ?>
                        @if ($menuLink->target && $menuLink->target->child)
                        <li>
                            <a href="{{ $menuLink->getRoute() }}">
                                <i class="fa fa-arrow-circle-right"></i> {{ $menuLink->name }}
                            </a>
                        </li>
                        @elseif ($menuLink->type)
                            <li>
                                <a href="{{ $menuLink->getRoute() }}">
                                    <i class="fa fa-th-list"></i> {{ $menuLink->name }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                    @if(Auth::check() && Auth::user()->isAdmin())
                        <li class="{{ $sidebar->active('menu_links') }}"><a href="{{ route('menu_links.index') }}"><i class="fa fa-lock"></i> {{ trans('sidebar.manage_links') }}</a></li>
                    @endif
                </ul>
            </li>
            @endif
            @if (Auth::check() && $currentCampaign->user())
                <li>
                    <a href="#" data-url="{{ route('entity-creator.selection') }}" data-toggle="ajax-modal" data-target="#entity-modal"><i class="fa fa-plus"></i> <span>{{ trans('sidebar.entity-creator') }}</span></a>
                </li>
            @endif

            @if ($campaign->enabled('characters'))
            <li class="{{ $sidebar->active('characters') }}">
                <a href="{{ route('characters.index') }}"><i class="fa fa-user"></i> <span>{{ trans('sidebar.characters') }}</span></a>
            </li>
            @endif
            @if ($campaign->enabled('families'))
            <li class="{{ $sidebar->active('families') }}">
                <a href="{{ route('families.' . $defaultIndex) }}"><i class="ra ra-double-team"></i> <span>{{ trans('sidebar.families') }}</span></a>
            </li>
            @endif
            @if ($campaign->enabled('locations'))
            <li class="{{ $sidebar->active('locations') }}">
                <a href="{{ route('locations.' . $defaultIndex) }}"><i class="ra ra-tower"></i> <span>{{ trans('sidebar.locations') }}</span></a>
            </li>
            @endif
            @if ($campaign->enabled('organisations'))
            <li class="{{ $sidebar->active('organisations') }}">
                <a href="{{ route('organisations.' . $defaultIndex) }}"><i class="ra ra-hood"></i> <span>{{ trans('sidebar.organisations') }}</span></a>
            </li>
            @endif
            @if ($campaign->enabled('items'))
            <li class="{{ $sidebar->active('items') }}">
                <a href="{{ route('items.index') }}"><i class="ra ra-gem-pendant"></i> <span>{{ trans('sidebar.items') }}</span></a>
            </li>
            @endif
            @if ($campaign->enabled('notes'))
            <li class="{{ $sidebar->active('notes') }}">
                <a href="{{ route('notes.index') }}"><i class="ra ra-quill-ink"></i> <span>{{ trans('sidebar.notes') }}</span></a>
            </li>
            @endif
            @if ($campaign->enabled('events'))
            <li class="{{ $sidebar->active('events') }}">
                <a href="{{ route('events.index') }}"><i class="fa fa-calendar"></i> <span>{{ trans('sidebar.events') }}</span></a>
            </li>
            @endif
            @if ($campaign->enabled('calendars'))
                <li class="{{ $sidebar->active('calendars') }}">
                    <a href="{{ route('calendars.index') }}"><i class="ra ra-moon-sun"></i> <span>{{ trans('sidebar.calendars') }}</span></a>
                </li>
            @endif
            @if ($campaign->enabled('races'))
                <li class="{{ $sidebar->active('races') }}">
                    <a href="{{ route('races.' . $defaultIndex) }}"><i class="ra ra-wyvern"></i> <span>{{ trans('sidebar.races') }}</span></a>
                </li>
            @endif
            @if ($campaign->enabled('quests'))
            <li class="{{ $sidebar->active('quests') }}">
                <a href="{{ route('quests.' . $defaultIndex) }}"><i class="ra ra-wooden-sign"></i> <span>{{ trans('sidebar.quests') }}</span></a>
            </li>
            @endif
            @if ($campaign->enabled('journals'))
            <li class="{{ $sidebar->active('journals') }}">
                <a href="{{ route('journals.index') }}"><i class="ra ra-scroll-unfurled"></i> <span>{{ trans('sidebar.journals') }}</span></a>
            </li>
            @endif
            @if ($campaign->enabled('tags'))
                <li class="{{ $sidebar->active('tags') }}">
                    <a href="{{ route('tags.' . $defaultIndex) }}"><i class="fa fa-tags"></i> <span>{{ trans('sidebar.tags') }}</span></a>
                </li>
            @endif
            @if ($campaign->enabled('dice_rolls'))
                <li class="{{ $sidebar->active('dice_rolls') }}">
                    <a href="{{ route('dice_rolls.index') }}"><i class="ra ra-dice-five"></i> <span>{{ trans('sidebar.dice_rolls') }}</span></a>
                </li>
            @endif
            @if ($campaign->enabled('conversations'))
                <li class="{{ $sidebar->active('conversations') }}">
                    <a href="{{ route('conversations.index') }}"><i class="ra ra-speech-bubbles"></i> <span>{{ trans('sidebar.conversations') }}</span></a>
                </li>
            @endif
            <li class="{{ $sidebar->active('attribute_templates') }}">
                <a href="{{ route('attribute_templates.index') }}"><i class="fa fa-copy"></i> <span>{{ trans('sidebar.attribute_templates') }}</span></a>
            </li>

            @auth
                @translator
                <li><a href="/translations"><i class="fa fa-globe"></i> <span>{{ trans('sidebar.translations') }}</span></a></li>
                @endtranslator
                @admin
                    <li><a href="{{ route('voyager.dashboard') }}"><i class="fa fa-lock"></i> <span>{{ trans('sidebar.admin') }}</span></a></li>
                @endadmin
                @moderator
                    <li><a href="{{ route('admin.campaigns.index') }}"><i class="fa fa-lock"></i> <span>{{ trans('sidebar.admin_campaigns.index') }}</span></a></li>
                @endmoderator
            @endauth
        </ul>
    </section>
</aside>
@elseif (Auth::check() && Auth::user()->hasCampaigns())
    <aside class="main-sidebar">
        <section class="sidebar">
            <ul class="sidebar-menu tree" data-widget="tree">
                @foreach (Auth::user()->campaigns as $campaign)
                <li class="">
                    <a href="{{ url(App::getLocale() . '/' . $campaign->getMiddlewareLink()) }}"><i class="fa fa-globe"></i> <span>{{ $campaign->name }}</span></a>
                </li>
                @endforeach
            </ul>
        </section>
    </aside>
@endif
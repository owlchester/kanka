<?php $campaign = CampaignLocalization::getCampaign(); ?>
@if (!empty($campaign))
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        {!! Form::open(array('route' => 'search', 'class' => 'sidebar-form', 'method'=>'GET')) !!}
        <div class="input-group">
            <input type="text" name="q" class="form-control" autocomplete="off"
                   placeholder="{{ trans('sidebar.search') }}" data-url="{{ route('search.live') }}"
                    data-empty="{{ trans('search.no_results') }}">
            <span class="input-group-btn">
                <button type="submit" id="search-btn" class="btn btn-flat">
                  <i class="fa fa-search"></i>
                </button>
              </span>
        </div>
        <div id="live-search-results" class="live-search-results"></div>
        {!! Form::close() !!}

        @inject('sidebar', 'App\Services\SidebarService')
        @inject('campaign', 'App\Services\CampaignService')

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu tree" data-widget="tree">
            <li class="header">{{ trans('sidebar.navigation') }}</li>
            <li class="{{ $sidebar->active('dashboard') }}">
                <a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('sidebar.dashboard') }}</span></a>
            </li>
            @if (Auth::check())
            <li class="{{ $sidebar->active('campaigns') }}">
                <a href="{{ route('campaigns.index') }}"><i class="fa fa-globe"></i> <span>{{ trans('sidebar.campaigns') }}</span></a>
            </li>
            @endif
            @if ($campaign->enabled('menu_links'))
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-link"></i>
                    <span>{{ trans('sidebar.custom_links') }}</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu" style="display: none;">
                    @foreach ($campaign->campaign()->menuLinks()->with(['entity'])->orderBy('name', 'ASC')->get() as $menuLink)
                        @if ($menuLink->entity && $menuLink->entity->child)
                        <li>
                            <a href="{{ route($menuLink->entity->pluralType() . '.show', $menuLink->entity->child->id) }}">
                                <i class="fa fa-circle-o"></i> {{ $menuLink->name }}
                            </a>
                        </li>
                        @endif
                    @endforeach
                    @if(Auth::check() && Auth::user()->isAdmin())
                        <li><a href="{{ route('menu_links.index') }}"><i class="fa fa-lock"></i> {{ trans('sidebar.manage_links') }}</a></li>
                    @endif
                </ul>
            </li>
            @endif

            @if ($campaign->enabled('characters'))
            <li class="{{ $sidebar->active('characters') }}">
                <a href="{{ route('characters.index') }}"><i class="fa fa-user"></i> <span>{{ trans('sidebar.characters') }}</span></a>
            </li>
            @endif
            @if ($campaign->enabled('families'))
            <li class="{{ $sidebar->active('families') }}">
                <a href="{{ route('families.index') }}"><i class="ra ra-double-team"></i> <span>{{ trans('sidebar.families') }}</span></a>
            </li>
            @endif
            @if ($campaign->enabled('locations'))
            <li class="{{ $sidebar->active('locations') }}">
                <a href="{{ route('locations.index') }}"><i class="ra ra-tower"></i> <span>{{ trans('sidebar.locations') }}</span></a>
            </li>
            @endif
            @if ($campaign->enabled('organisations'))
            <li class="{{ $sidebar->active('organisations') }}">
                <a href="{{ route('organisations.index') }}"><i class="ra ra-hood"></i> <span>{{ trans('sidebar.organisations') }}</span></a>
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
                <a href="{{ route('events.index') }}"><i class="fa fa-calendar-o"></i> <span>{{ trans('sidebar.events') }}</span></a>
            </li>
            @endif
            @if ($campaign->enabled('calendars'))
                <li class="{{ $sidebar->active('calendars') }}">
                    <a href="{{ route('calendars.index') }}"><i class="ra ra-moon-sun"></i> <span>{{ trans('sidebar.calendars') }}</span></a>
                </li>
            @endif
            @if ($campaign->enabled('quests'))
            <li class="{{ $sidebar->active('quests') }}">
                <a href="{{ route('quests.index') }}"><i class="ra ra-wooden-sign"></i> <span>{{ trans('sidebar.quests') }}</span></a>
            </li>
            @endif
            @if ($campaign->enabled('journals'))
            <li class="{{ $sidebar->active('journals') }}">
                <a href="{{ route('journals.index') }}"><i class="ra ra-scroll-unfurled"></i> <span>{{ trans('sidebar.journals') }}</span></a>
            </li>
            @endif
            @if ($campaign->enabled('sections'))
                <li class="{{ $sidebar->active('sections') }}">
                    <a href="{{ route('sections.index') }}"><i class="fa fa-folder-open"></i> <span>{{ trans('sidebar.sections') }}</span></a>
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
            @can('create', 'App\Models\AttributeTemplate')
            <li class="{{ $sidebar->active('attribute_templates') }}">
                <a href="{{ route('attribute_templates.index') }}"><i class="fa fa-copy"></i> <span>{{ trans('sidebar.attribute_templates') }}</span></a>
            </li>
            @endif

            <li class="treeview {{ $sidebar->active('other', 'menu-open') }}">
                <a href="#">
                    <i class="fa fa-share"></i> <span>{{ trans('sidebar.other') }}</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu" style="display: {{ ($sidebar->active('other', true) ? 'block' : 'hidden' )}};">
                    <li class="{{ $sidebar->active('releases') }}">
                        <a href="{{ route('releases.index') }}"><i class="fa fa-ticket"></i> {{ trans('sidebar.releases') }}</a>
                    </li>
                    <li><a href="{{ route('about') }}"><i class="fa fa-info-circle"></i> {{ trans('front.menu.about') }}</a></li>
                    <li><a href="{{ route('help') }}"><i class="fa fa-exclamation-circle"></i> {{ trans('front.menu.help') }}</a></li>
                    <li><a href="{{ route('faq') }}"><i class="fa fa-question-circle"></i>{{ trans('front.menu.faq') }}</a></li>


                    <li><a href="https://www.reddit.com/r/kanka" target="_blank"><i class="fa fa-reddit"></i> {{ trans('sidebar.support') }}</a></li>
                    <li><a href="https://discord.gg/rhsyZJ4" target="_blank"><i class="fa fa-commenting-o"></i> {{ trans('sidebar.discord') }}</a></li>
                    <li><a href="https://www.patreon.com/kankaio" target="_blank"><i class="fa fa-gratipay"></i> {{ trans('sidebar.patreon') }}</a></li>
                    <li><a href="https://trello.com/b/62aOwCHU/kanka" target="_blank"><i class="fa fa-trello"></i> {{ trans('sidebar.trello') }}</a></li>
                </ul>
            </li>

            @if (Auth::check() && Auth::user()->is_translator)
                <li><a href="/translations"><i class="fa fa-globe"></i> <span>{{ trans('sidebar.translations') }}</span></a></li>
            @endif


            @if (Auth::check() && Auth::user()->hasRole('admin'))
                <li><a href="{{ route('voyager.dashboard') }}"><i class="fa fa-lock"></i> <span>{{ trans('sidebar.admin') }}</span></a></li>
                {{--<li><a href="{{ route('admin.campaigns.index') }}"><i class="fa fa-lock"></i> <span>{{ trans('sidebar.admin_campaigns.index') }}</span></a></li>--}}
            @elseif (Auth::check() && Auth::user()->hasRole('moderator'))
                <li><a href="{{ route('admin.campaigns.index') }}"><i class="fa fa-lock"></i> <span>{{ trans('sidebar.admin_campaigns.index') }}</span></a></li>
            @endif
        </ul><!-- /.sidebar-menu -->

    </section>
    <!-- /.sidebar -->
</aside>
@elseif (Auth::check() && Auth::user()->hasCampaigns())
    <aside class="main-sidebar">
        <section class="sidebar">
            <ul class="sidebar-menu tree" data-widget="tree">
                <li class="header">{{ trans('sidebar.navigation') }}</li>
                @foreach (Auth::user()->campaigns as $campaign)
                <li class="">
                    <a href="{{ url(App::getLocale() . '/' . $campaign->getMiddlewareLink()) }}"><i class="fa fa-globe"></i> <span>{{ $campaign->name }}</span></a>
                </li>
                @endforeach
            </ul>
        </section>
    </aside>
@endif
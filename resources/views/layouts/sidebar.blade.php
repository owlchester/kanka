@if (Session::has('campaign_id'))
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        {!! Form::open(array('route' => 'search', 'class' => 'sidebar-form', 'method'=>'GET')) !!}
        <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="{{ trans('sidebar.search') }}">
            <span class="input-group-btn">
                <button type="submit" id="search-btn" class="btn btn-flat">
                  <i class="fa fa-search"></i>
                </button>
              </span>
        </div>
        {!! Form::close() !!}

        @inject('sidebar', 'App\Services\SidebarService')
        @inject('campaign', 'App\Services\CampaignService')

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu tree" data-widget="tree">
            <li class="header">{{ trans('sidebar.navigation') }}</li>
            <li class="{{ $sidebar->active('dashboard') }}">
                <a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('sidebar.dashboard') }}</span></a>
            </li>
            <li class="{{ $sidebar->active('campaigns') }}">
                <a href="{{ route('campaigns.index') }}"><i class="fa fa-globe"></i> <span>{{ trans('sidebar.campaigns') }}</span></a>
            </li>
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
                        @if ($menuLink->entity->child)
                        <li>
                            <a href="{{ route($menuLink->entity->pluralType() . '.show', $menuLink->entity->child->id) }}">
                                <i class="fa fa-circle-o"></i> {{ $menuLink->name }}
                            </a>
                        </li>
                        @endif
                    @endforeach
                    @if(Auth::user()->isAdmin())
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
                <a href="{{ route('families.index') }}"><i class="fa fa-sitemap"></i> <span>{{ trans('sidebar.families') }}</span></a>
            </li>
            @endif
            @if ($campaign->enabled('locations'))
            <li class="{{ $sidebar->active('locations') }}">
                <a href="{{ route('locations.index') }}"><i class="fa fa-globe"></i> <span>{{ trans('sidebar.locations') }}</span></a>
            </li>
            @endif
            @if ($campaign->enabled('organisations'))
            <li class="{{ $sidebar->active('organisations') }}">
                <a href="{{ route('organisations.index') }}"><i class="fa fa-user-secret"></i> <span>{{ trans('sidebar.organisations') }}</span></a>
            </li>
            @endif
            @if ($campaign->enabled('items'))
            <li class="{{ $sidebar->active('items') }}">
                <a href="{{ route('items.index') }}"><i class="fa fa-shield"></i> <span>{{ trans('sidebar.items') }}</span></a>
            </li>
            @endif
            @if ($campaign->enabled('notes'))
            <li class="{{ $sidebar->active('notes') }}">
                <a href="{{ route('notes.index') }}"><i class="fa fa-file"></i> <span>{{ trans('sidebar.notes') }}</span></a>
            </li>
            @endif
            @if ($campaign->enabled('events'))
            <li class="{{ $sidebar->active('events') }}">
                <a href="{{ route('events.index') }}"><i class="fa fa-calendar-o"></i> <span>{{ trans('sidebar.events') }}</span></a>
            </li>
            @endif
            @if ($campaign->enabled('calendars'))
                <li class="{{ $sidebar->active('calendars') }}">
                    <a href="{{ route('calendars.index') }}"><i class="fa fa-calendar"></i> <span>{{ trans('sidebar.calendars') }}</span></a>
                </li>
            @endif
            @if ($campaign->enabled('quests'))
            <li class="{{ $sidebar->active('quests') }}">
                <a href="{{ route('quests.index') }}"><i class="fa fa-list"></i> <span>{{ trans('sidebar.quests') }}</span></a>
            </li>
            @endif
            @if ($campaign->enabled('journals'))
            <li class="{{ $sidebar->active('journals') }}">
                <a href="{{ route('journals.index') }}"><i class="fa fa-book"></i> <span>{{ trans('sidebar.journals') }}</span></a>
            </li>
            @endif
            @if ($campaign->enabled('sections'))
                <li class="{{ $sidebar->active('sections') }}">
                    <a href="{{ route('sections.index') }}"><i class="fa fa-folder-open"></i> <span>{{ trans('sidebar.sections') }}</span></a>
                </li>
            @endif
            @if ($campaign->enabled('dice_rolls'))
                <li class="{{ $sidebar->active('dice_rolls') }}">
                    <a href="{{ route('dice_rolls.index') }}"><i class="fa fa-square"></i> <span>{{ trans('sidebar.dice_rolls') }}</span></a>
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
                </ul>
            </li>

            @if (Auth::user()->is_translator)
                <li><a href="/translations"><i class="fa fa-globe"></i> <span>{{ trans('sidebar.translations') }}</span></a></li>
            @endif


            @if (Auth::user()->hasRole('admin'))
            <li><a href="{{ route('voyager.dashboard') }}"><i class="fa fa-lock"></i> <span>{{ trans('sidebar.admin') }}</span></a></li>
            @endif
        </ul><!-- /.sidebar-menu -->

    </section>
    <!-- /.sidebar -->
</aside>
@endif
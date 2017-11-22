@if (Session::has('campaign_id'))
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        {!! Form::open(array('route' => 'search', 'class' => 'sidebar-form', 'method'=>'GET')) !!}
        <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Search...">
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
                <a href="{{ route('items.index') }}"><i class="fa fa-wrench"></i> <span>{{ trans('sidebar.items') }}</span></a>
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
                    <li><a href="https://www.reddit.com/r/kanka" target="_blank"><i class="fa fa-reddit"></i> {{ trans('sidebar.support') }}</a></li>
                    <li><a href="https://www.patreon.com/kankaio" target="_blank"><i class="fa fa-gratipay"></i> {{ trans('sidebar.patreon') }}</a></li>
                </ul>
            </li>


            @if (Auth::user()->hasRole('admin'))
            <li><a href="{{ route('voyager.dashboard') }}"><i class="fa fa-lock"></i> <span>{{ trans('sidebar.admin') }}</span></a></li>
            @endif
        </ul><!-- /.sidebar-menu -->

    </section>
    <!-- /.sidebar -->
</aside>
@endif
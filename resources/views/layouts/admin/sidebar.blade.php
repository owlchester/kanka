@inject('sidebar', 'App\Services\SidebarService')

<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu tree" data-widget="tree">
            <li class="{{ $sidebar->admin('dashboard') }}">
                <a href="{{ route('admin.home') }}"><i class="fa fa-th-large"></i> <span>{{ __('sidebar.dashboard') }}</span></a>
            </li>
            <li class="{{ $sidebar->admin('users') }}">
                <a href="{{ route('admin.users.index') }}"><i class="fa fa-users"></i> <span>Users</span></a>
            </li>
            <li class="{{ $sidebar->admin('campaigns') }}">
                <a href="{{ route('admin.campaigns.index') }}"><i class="fa fa-globe"></i> <span>{{ __('sidebar.campaigns') }}</span></a>
            </li>
            <li class="{{ $sidebar->admin('community-votes') }}">
                <a href="{{ route('admin.community-votes.index') }}"><i class="fas fa-check-square"></i> <span>Community Votes</span></a>
            </li>
            <li class="{{ $sidebar->admin('community-events') }}">
                <a href="{{ route('admin.community-events.index') }}"><i class="fas fa-calendar"></i> <span>Community Events</span></a>
            </li>
            <li class="{{ $sidebar->admin('app-releases') }}">
                <a href="{{ route('admin.app-releases.index') }}"><i class="fa fa-plus"></i> <span>Releases</span></a>
            </li>
            <li class="{{ $sidebar->admin('faq') }}">
                <a href="{{ route('admin.faq.index') }}"><i class="fa fa-question-circle"></i> <span>FAQ / KB</span></a>
            </li>
            <li class="{{ $sidebar->admin('faq-categories') }}">
                <a href="{{ route('admin.faq-categories.index') }}"><i class="fa fa-solar-panel"></i> <span>FAQ Categories</span></a>
            </li>
            <li class="{{ $sidebar->admin('referrals') }}">
                <a href="{{ route('admin.referrals.index') }}"><i class="fa fa-user-tag"></i> <span>Referrals</span></a>
            </li>
            <li class="{{ $sidebar->admin('ads') }}">
                <a href="{{ route('admin.ads.index') }}"><i class="fa fa-dollar"></i> <span>Ads</span></a>
            </li>
            <li class="{{ $sidebar->admin('cache') }}">
                <a href="{{ route('admin.cache') }}"><i class="fa fa-hourglass-half"></i> <span>Cache</span></a>
            </li>
        </ul><!-- /.sidebar-menu -->

    </section>
    <!-- /.sidebar -->
</aside>

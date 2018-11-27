@inject('sidebar', 'App\Services\SidebarService')

<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu tree" data-widget="tree">
            <li class="header">{{ trans('sidebar.navigation') }}</li>
            <li class="{{ $sidebar->active('dashboard') }}">
                <a href="{{ route('admin.home') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('sidebar.dashboard') }}</span></a>
            </li>
            <li class="{{ $sidebar->active('campaigns') }}">
                <a href="{{ route('admin.campaigns.index') }}"><i class="fa fa-globe"></i> <span>{{ trans('sidebar.campaigns') }}</span></a>
            </li>
        </ul><!-- /.sidebar-menu -->

    </section>
    <!-- /.sidebar -->
</aside>
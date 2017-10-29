@if (Session::has('campaign_id'))
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">{{ config('app.name') }}</li>
            <!-- Optionally, you can add icons to the links -->
            <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('sidebar.dashboard') }}</span></a></li>
            <li><a href="{{ route('characters.index') }}"><i class="fa fa-user"></i> <span>{{ trans('sidebar.characters') }}</span></a></li>
            <li><a href="{{ route('locations.index') }}"><i class="fa fa-globe"></i> <span>{{ trans('sidebar.locations') }}</span></a></li>

            <li><a href="{{ url('/admin') }}"><i class="fa fa-lock"></i> <span>Admin</span></a></li>
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
@endif
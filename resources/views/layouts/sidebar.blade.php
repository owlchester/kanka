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


        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">Navigation</li>
            <!-- Optionally, you can add icons to the links -->
            <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('sidebar.dashboard') }}</span></a></li>
            <li><a href="{{ route('characters.index') }}"><i class="fa fa-user"></i> <span>{{ trans('sidebar.characters') }}</span></a></li>
            <li><a href="{{ route('families.index') }}"><i class="fa fa-sitemap"></i> <span>{{ trans('sidebar.families') }}</span></a></li>
            <li><a href="{{ route('locations.index') }}"><i class="fa fa-globe"></i> <span>{{ trans('sidebar.locations') }}</span></a></li>
            <li><a href="{{ route('organisations.index') }}"><i class="fa fa-user-secret"></i> <span>{{ trans('sidebar.organisations') }}</span></a></li>
            <li><a href="{{ route('items.index') }}"><i class="fa fa-wrench"></i> <span>{{ trans('sidebar.items') }}</span></a></li>
            <li><a href="{{ route('journals.index') }}"><i class="fa fa-book"></i> <span>{{ trans('sidebar.journals') }}</span></a></li>

            <!--<li><a href="{{ url('/admin') }}"><i class="fa fa-lock"></i> <span>Admin</span></a></li>-->
        </ul><!-- /.sidebar-menu -->

    </section>
    <!-- /.sidebar -->
</aside>
@endif
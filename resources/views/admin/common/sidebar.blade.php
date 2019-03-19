<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo Auth::guard('admin')->user()->avatar ? url('').'/'.Auth::guard('admin')->user()->avatar : url('').'/'.'system_static_file/img/user_avatar.png';?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ Auth::guard('admin')->user()->username }}</p>
                <!-- Status -->
                <a href="#" target="menuFrame"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form (Optional) -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
        {{--<li class="header"></li>--}}
        <!-- Optionally, you can add icons to the links -->
            @if(!empty(session('menus')[0]))
                @foreach( session('menus')[0] as $menu )
                    <li class="treeview">
                        <a href="#">
                            {{--<i class="fa fa-link" target="menuFrame"></i> --}}
                            <span>{{ $menu->auth_name }}</span>
                            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
                        </a>
                        <ul class="treeview-menu">
                            @if(!empty(session('menus')[$menu->id]))
                                @foreach(session('menus')[$menu->id] as $k )
                                    <li><a href="{{ url("admin/$k->auth_controller") }}" target="menuFrame">{{ $k->auth_name }}</a></li>
                                @endforeach
                            @endif
                        </ul>
                    </li>
                @endforeach
            @endif
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>

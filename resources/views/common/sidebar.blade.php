<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{asset('dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>
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
            <li class="treeview">
                <a href="#"><i class="fa fa-link"></i> <span>营业看板</span>
                    <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('admin/index') }}" target="menuFrame">首页</a></li>
                    <li><a href="#" target="menuFrame">角色管理</a></li>
                    <li><a href="#" target="menuFrame">系统管理员</a></li>
                </ul>
            </li>
            <li>
                <a href="#" target="menuFrame"><i class="fa fa-link"></i> <span>Another Link</span></a>
            </li>
            <li class="treeview">
                <a href="#"><i class="fa fa-link" target="menuFrame"></i> <span>系统管理员</span>
                    <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('admin/auth') }}" target="menuFrame">权限管理</a></li>
                    <li><a href="{{ url('admin/role') }}" target="menuFrame">角色管理</a></li>
                    <li><a href="{{ url('admin/admin') }}" target="menuFrame">系统管理员</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#"><i class="fa fa-link" target="menuFrame"></i> <span>Multilevel</span>
                    <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#" target="menuFrame">Link in level 2</a></li>
                    <li><a href="#" target="menuFrame">Link in level 2</a></li>
                </ul>
            </li>
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
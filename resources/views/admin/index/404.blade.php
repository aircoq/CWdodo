@extends('admin.common.common')

@section('title')

@endsection

@section('css')

@endsection

@section('content')
  <div class="wrapper">
    <!-- 顶部主菜单 -->
  @include('admin.common.header')
  <!-- 左侧菜单栏：包含标志和侧栏 -->
  @include('admin.common.sidebar')
  <!-- 内容容器开始（包含页面内容） -->
    <div class="content-wrapper">
      <!-- 内容页眉标题 -->
      <section class="content-header">
        <h1>
          404错误
          <small></small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Here</li>
        </ol>
      </section>

      <!-- 主要内容 -->
      <section class="content container-fluid">
        <!--------------------------
          |   你的页面内容放在这里   |
          -------------------------->
        <section class="content">
          <div class="error-page">
            <h2 class="headline text-yellow"> 404</h2>

            <div class="error-content">
              <h3><i class="fa fa-warning text-yellow"></i>请求的页面不存在.</h3>

              <p>
                我们找不到你要找的那一页。您可以返回 <a href="{{ url('admin/index') }}">首页</a> 或尝试使用搜索表单.
              </p>

              <form class="search-form">
                <div class="input-group">
                  <input type="text" name="search" class="form-control" placeholder="Search">

                  <div class="input-group-btn">
                    <button type="submit" name="submit" class="btn btn-warning btn-flat"><i class="fa fa-search"></i>
                    </button>
                  </div>
                </div>
                <!-- /.input-group -->
              </form>
            </div>
            <!-- /.error-content -->
          </div>
          <!-- /.error-page -->
        </section>

      </section>
      <!-- /.主要内容结束 -->
    </div>
    <!-- /.内容容器结束 -->

    <!-- 页脚 -->
    @include('admin.common.footer');

    <!-- 控制台 -->
    @include('admin.common.control');
    <!-- /.control-sidebar -->
    <!-- 添加侧边栏的背景。必须放置此div在控件侧边栏之后 -->
    <div class="control-sidebar-bg"></div>
  </div>
@endsection

@section('script')

@endsection
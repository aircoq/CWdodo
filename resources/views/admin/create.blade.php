@extends('admin.common.common')

@section('title')

@endsection

@section('css')

@endsection

@section('content')
    <div class="content-wrapper">
        <!-- 内容页眉(页眉) -->
        <section class="content-header">
            <h1>
                系统管理员
                <small>新增</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Here</li>
            </ol>
        </section>

        <!-- 主要内容 -->
        <section class="content container-fluid">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">新增系统管理员</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="{{ url('admin/admin')  }}" method="post" enctype="multipart/form-data" >
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputNickname1">姓名</label>
                            <input type="text" class="form-control" name="username" id="nickname" placeholder="姓名">
                        </div>
                        <div class="form-group">
                            <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">性别</font></font></label>
                            <select class="form-control" name="sex">
                                <option value="0"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">女</font></font></option>
                                <option value="1"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">男</font></font></option>
                                <option value="2"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">保密</font></font></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPhone1">手机</label>
                            <input type="tel" class="form-control" name="phone" id="phone" placeholder="手机">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">邮箱</label>
                            <input type="email" class="form-control" name="email" id="exampleInputEmail1" placeholder="邮箱">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">密码</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="密码">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">密码</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" name="password_confirmation" placeholder="确认密码">
                        </div>
                        <div class="form-group">
                            <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">角色</font></font></label>
                            <select class="form-control" name="role_id">
                                <option><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">选项1</font></font></option>
                                <option><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">选项2</font></font></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">账号状态</font></font></label>
                                <select class="form-control" name="admin_status">
                                <option value="-2"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">拒绝</font></font></option>
                                <option value="-1"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">已停止</font></font></option>
                                <option value="1" selected><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">未审核</font></font></option>
                                <option value="2"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">通过</font></font></option>
                            </select>
                        </div>
                        <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">备注</font></font></label>
                        <textarea class="textarea" placeholder="备注" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                        <div class="form-group">
                            <label for="exampleInputFile">上传头像</label>
                            <input type="file" id="files" name="avatar" files>
                            <p class="help-block">不大于500k，接收png，gif，jpeg，jpg格式</p>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox"> 已阅读并同意公司隐私协议
                            </label>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">确认提交</button>
                    </div>
                </form>
            </div>
        </section>
        <!-- /.主要内容结束 -->
    </div>
@endsection

@section('script')
    <>
@endsection
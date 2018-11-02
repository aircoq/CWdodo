@extends('admin.common.common')

@section('title')

@endsection

@section('css')
    <style>
        .error{color:red;}
    </style>
@endsection

@section('content')
    <div class="cl-sm-12">
        <!-- /.box-header -->
        <!-- form start -->
        <form class="form-horizontal" id="form-admin-edit" action="{{ url('admin/admin/' . $admin_info->id ) }}" method="post">
            {{ csrf_field() }}
            {{ method_field('put') }}
            <div class="box-body">
                <div class="form-group">
                    <br/>
                    <label class="col-sm-3 control-label"></label>
                    <div class="col-sm-7">
                        <a href="javascript:;" onclick="layer_show('上传头像','{{ url('admin/avatar_upload?id='.$admin_info->id) }}','350','350')" id="a-admin-avatar">
                            <img src="{{ url("$admin_info->avatar" ? "$admin_info->avatar" : 'sys_img/user_avatar.png') }}" style="width:15%;height:15%;display:flex;border-radius: 50%;align-items: center;justify-content:center;overflow: hidden;"/>
                        </a>
                    </div>
                </div>
                <br/>
                <div class="form-group">
                    <label class="col-sm-2 control-label">姓名</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" style="width:70%;display:inline;" placeholder="姓名" name="username" id="username" value="{{$admin_info->username}}"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">性别</label>
                    <div class="col-sm-10">
                        <select class="form-control" style="width:70%;" name="sex" >
                            <option id="sex0" value="0">女</option>
                            <option id="sex1" value="1">男</option>
                            <option id="sex2" value="2">保密</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">手机</label>
                    <div class="col-sm-10">
                        <input type="tel" class="form-control" style="width:70%;display:inline;" placeholder="手机"  name="phone" id="phone" value="{{$admin_info->phone}}"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">邮箱</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" style="width:70%;display:inline;" placeholder="邮箱" name="email" id="email" value="{{$admin_info->email}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">密码</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" style="width:70%;display:inline;" placeholder="密码" id="password" name="password"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">确认密码</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" style="width:70%;display:inline;" placeholder="确认密码" id="confirm_password" name="confirm_password">
                    </div>
                </div>
                <div class="form-group" id="div-role-id">
                    <label class="col-sm-2 control-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">角色</font></font></label>
                    <div class="col-sm-10">
                        <select class="form-control" name="role_id" style="width:70%;">
                            <option value="1" id=""><font  style="vertical-align: inherit;"><font style="vertical-align: inherit;">选项1</font></font></option>
                            <option value="2" id=""><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">选项2</font></font></option>
                        </select>
                    </div>
                </div>
                <div class="form-group" id="div-admin-status">
                    <label class="col-sm-2 control-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">账号状态</font></font></label>
                    <div class="col-sm-10">
                        <select class="form-control" style="width:70%;" name="admin_status">
                            <option value="-2" id="admin_status-2"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">拒绝</font></font></option>
                            <option value="-1" id="admin_status-1"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">已停止</font></font></option>
                            <option value="0" id="admin_status0"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">未审核</font></font></option>
                            <option value="1" id="admin_status1"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">通过</font></font></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">备注</label>
                    <div class="col-sm-10">
                        <textarea class="textarea" style="width: 70%; height: 100px; font-size: 14px;" placeholder="备注" name="note"></textarea>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <label class="col-sm-2 control-label"></label>
                <div class="col-sm-10">
                    <input type="submit" class="btn btn-primary radius" value="确认提交"/>
                </div>
            </div>
        </form>
    </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('plugins/validation/jquery.validate.js')}}"></script>
    <script type="text/javascript" src="{{ asset('plugins/validation/validate-methods.js')}}"></script>
    <script type="text/javascript" src="{{ asset('plugins/validation/messages_zh.js')}}"></script>
    <script type="text/javascript" src="{{ asset('plugins/layer/layer.js')}}"></script>
    <script type="text/javascript" src="{{ asset('plugins/layer/admin_layer.js')}}"></script>
    <script type="text/javascript" src="{{ asset('plugins/layer/admin_layer.js')}}"></script>
    <script type="text/javascript" src="{{ asset('plugins/jQueryUI/jquery.form.js')}}"></script>
    <script>
        $(function(){
            /** 数据渲染 ***/
            //隐藏无权限部分
            var role_id_now = "<?php echo (Auth::guard('admin')->user()->role_id); ?>";//当前用户role_id
            var role_id_edit = "<?php echo $admin_info->role_id; ?>";//被编辑的用户id
            if(role_id_now != '*' || role_id_edit=='*' ){//当前不是超级管理员或在编辑管理员
                $('#div-role-id').remove();
                $('#div-admin-status').remove();
            }
            $('#sex{{$admin_info->sex}}').attr('selected','selected');//性别选中
            $('#admin_status{{$admin_info->admin_status}}').attr('selected','selected');//状态选中

            /***编写Javascript表单验证区域*/
            $("#form-admin-edit").validate({
                rules:{//规则
                    username:{
                        rangelength:[5,12]
                    },
                    phone:{
                        minlength:11,
                        maxlength:11,
                        digits:true
                    },
                    email:{
                        email:true,
                    },
                    password:{
                        rangelength:[5,20]
                    },
                    confirm_password:{
                        equalTo: "#password"
                    },
                    form_check:{
                        required:true,
                    },
                },
                messages: {//自定义提示信息
                    form_check:{
                        required:"请仔细阅读相关条款",
                    },
                },
                onkeyup:false,
                focusCleanup:false,
                errorElement: "span",
                errorPlacement: function(error, element) {//错误信息位置设置方法
                    error.appendTo( element.parent());//这里的element是录入数据的对象
                },
                submitHandler:function(form){
                    $(form).ajaxSubmit(function(msg){
                        if( msg.status != 'success' ){
                            layer.alert(msg.msg, {
                                icon: 5,
                                skin: 'layer-ext-moon'
                            });
                        }else{ // 成功
                            layer.msg('更新成功！', {
                                icon: 1,
                                skin: 'layer-ext-moon'
                            },function(){
                                parent.location.reload();
                                var index = parent.layer.getFrameIndex(window.name);
                                parent.layer.close(index);
                            });
                        }
                    });
                }
            });
        });
    </script>
@endsection
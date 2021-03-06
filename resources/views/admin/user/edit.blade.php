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
        <form class="form-horizontal" id="form-admin-edit" action="{{ url('admin/user/' . $user->id ) }}" method="post">
            {{ csrf_field() }}
            {{ method_field('put') }}
            <div class="box-body">
                <div class="form-group">
                    <br/>
                    <label class="col-sm-3 control-label"></label>
                    <div class="col-sm-7">
                        <a href="javascript:;" onclick="layer_show('上传头像','{{ url('home/avatar_upload?id='.$user->id) }}','350','350')" id="a-admin-avatar">
                            <img src="{{ url("$user->avatar" ? "$user->avatar" : 'system_static_file/img/user_avatar.png') }}" style="width:15%;height:15%;display:flex;border-radius: 50%;align-items: center;justify-content:center;overflow: hidden;"/>
                        </a>
                    </div>
                </div>
                <br/>
                <div class="form-group">
                    <label class="col-sm-2 control-label">昵称</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" style="width:70%;display:inline;" placeholder="姓名" name="nickname" id="nickname" value="{{$user->nickname}}"/>
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
                        <input type="tel" class="form-control" style="width:70%;display:inline;" placeholder="手机"  name="phone" id="phone" value="{{$user->phone}}"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">邮箱</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" style="width:70%;display:inline;" placeholder="邮箱" name="email" id="email" value="{{$user->email}}">
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
                <div class="form-group" id="div-admin-status">
                    <label class="col-sm-2 control-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">账号状态</font></font></label>
                    <div class="col-sm-10">
                        <select class="form-control" style="width:70%;" name="user_status">
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
                        <textarea class="textarea" style="width: 70%; height: 100px; font-size: 14px;" placeholder="管理员备注" name="note"></textarea>
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
            $('#sex{{$user->sex}}').attr('selected','selected');//性别选中
            $('#admin_status{{$user->user_status}}').attr('selected','selected');//状态选中

            /***编写Javascript表单验证区域*/
            $("#form-admin-edit").validate({
                rules:{//规则
                    nickname:{
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
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
                <form class="form-horizontal" id="form-admin-add" action="{{ url('admin/admin')  }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">姓名</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" style="width:70%;display:inline;" placeholder="姓名" name="username" id="username"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">性别</label>
                            <div class="col-sm-10">
                                <select class="form-control" style="width:70%;" name="sex" >
                                    <option value="0">女</option>
                                    <option value="1">男</option>
                                    <option value="2">保密</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">手机</label>
                            <div class="col-sm-10">
                                <input type="tel" class="form-control" style="width:70%;display:inline;" placeholder="手机"  name="phone" id="phone"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">邮箱</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" style="width:70%;display:inline;" placeholder="邮箱" name="email" id="email">
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
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">角色</font></font></label>
                            <div class="col-sm-10">
                                <select class="form-control" name="role_id" style="width:70%;">
                                    <option value="1"><font  style="vertical-align: inherit;"><font style="vertical-align: inherit;">选项1</font></font></option>
                                    <option value="2"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">选项2</font></font></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">账号状态</font></font></label>
                            <div class="col-sm-10">
                                <select class="form-control" style="width:70%;" name="admin_status">
                                    <option value="-2"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">拒绝</font></font></option>
                                    <option value="-1"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">已停止</font></font></option>
                                    <option value="0" selected><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">未审核</font></font></option>
                                    <option value="1"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">通过</font></font></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">备注</label>
                            <div class="col-sm-10">
                                <textarea class="textarea" style="width: 70%; height: 200px; font-size: 14px;" placeholder="备注" name="note"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="checkbox">
                                <label class="col-sm-2 control-label"></label>
                                <div class="col-sm-10">
                                    <input type="checkbox" id="form_check" name="form_check"> 已阅读并同意公司隐私协议
                                </div>

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
            /***编写Javascript表单验证区域*/
            $("#form-admin-add").validate({
                rules:{//规则
                    username:{
                        required:true,
                        rangelength:[5,12]
                    },
                    phone:{
                        required:true,
                        minlength:11,
                        maxlength:11,
                        digits:true
                    },
                    email:{
                        required:true,
                        email:true,
                    },
                    password:{
                        required:true,
                        rangelength:[5,20]
                    },
                    confirm_password:{
                        required:true,
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
                            layer.msg('添加成功！', {
                                icon: 1,
                                skin: 'layer-ext-moon'
                            },function(){
                                parent.location.reload();
                                var index = parent.layer.getFrameIndex( window.name );
                                parent.layer.close(index);
                            });
                        }
                    });
                }
            });
        });
    </script>
@endsection
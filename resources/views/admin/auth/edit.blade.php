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
                <form class="form-horizontal" id="form-admin-add" action="{{ url('admin/auth/' . $auth->id)  }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('put') }}
                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">模块/权限名称</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" style="width:70%;display:inline;" placeholder="权限名称，显示在菜单栏的名称" name="auth_name" id="auth_name" value="{{ $auth->auth_name }}"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">所属控制器</label>
                            <div class="col-sm-10">
                                <input type="tel" class="form-control" style="width:70%;display:inline;" placeholder="路由中的控制器"  name="auth_controller" id="auth_controller" value="{{ $auth->auth_controller }}"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">所属控制器下的方法</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" style="width:70%;display:inline;" placeholder="路由下的方法名" name="auth_action" id="auth_action" value="{{ $auth->auth_action }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">父级菜单</font></font></label>
                            <div class="col-sm-10">
                                <select class="form-control" style="width:70%;" name="auth_pid">
                                    <option value="0"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">顶级菜单</font></font></option>
                                    @foreach ($all_auth as $v)
                                    <option value="{{ $v['id'] }}">
                                        <font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
                                                <?php
                                                for ($i=$v['path'];$i>0;$i--){
                                                    echo '&nbsp&nbsp&nbsp&nbsp&nbsp';
                                                }
                                                ?>
                                                {{ $v['auth_name'] }}
                                        </font></font>
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">作为左边的菜单显示</font></font></label>
                            <div class="col-sm-10">
                                <div class="col-sm-4 radio">
                                    <label>
                                        <input type="radio" name="is_menu" id="is_menu" value="1" checked="">是
                                    </label>
                                </div>
                                <div class="col-sm-6 radio">
                                    <label>
                                        <input type="radio" name="is_menu" id="is_menu" value="0" checked="">否
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">是否可用</font></font></label>
                            <div class="col-sm-10">
                                <div class="col-sm-4 radio">
                                    <label>
                                        <input type="radio" name="is_enable" id="is_enable" value="1" checked="">是
                                    </label>
                                </div>
                                <div class="col-sm-6 radio">
                                    <label>
                                        <input type="radio" name="is_enable" id="is_enable" value="0" checked="">否
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">排序权重</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" style="width:70%;display:inline;" placeholder="数值越大排名越前" id="sort_order" name="sort_order" value="{{ $auth->sort_order }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">权限描述</label>
                            <div class="col-sm-10">
                                <textarea class="textarea" style="width: 70%; height: 200px; font-size: 14px;" placeholder="管理员的备注" name="auth_desc">{{ $auth->auth_desc }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">提示</label>
                        <div class="col-sm-10">
                            <div style="width:70%;">
                                一层菜单为：显示是，可用否，控制器方法为空；二级菜单为显示是，可用是，只填控制器，方法‘index’需省略；三级一般为显示否，可用是（按钮类型），方法和控制器必填
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
                    auth_name:{
                        required:true,
                        rangelength:[2,10]
                    },
                },
                messages: {//自定义提示信息
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
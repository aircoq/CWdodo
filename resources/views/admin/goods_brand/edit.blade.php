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
        <form class="form-horizontal" id="form-admin-add" action="{{ url('admin/goods_type/'.$goods_type->id )  }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('put') }}
            <div class="box-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label">商品类型名称</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" style="width:70%;display:inline;" placeholder="商品类型名称" name="type_name" id="type_name" value="{{ $goods_type->type_name }}" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">商品类型说明</label>
                    <div class="col-sm-10">
                        <textarea class="textarea" style="width: 70%; height: 150px; font-size: 14px;" placeholder="管理员的备注" name="mark_up">{{ $goods_type->mark_up }}</textarea>
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
                    nickname:{
                        required:true,
                        rangelength:[3,12]
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
                            layer.msg(msg.msg, {
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
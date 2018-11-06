@extends('admin.common.common')

@section('title')

@endsection

@section('css')
    <link rel="stylesheet" href="{{asset('plugins/timepicker/bootstrap-timepicker.min.css')}}">
    <style>
        .error{color:red;}
    </style>
@endsection

@section('content')
    <div class="cl-sm-12">
        <!-- /.box-header -->
        <!-- form start -->
        <form class="form-horizontal" id="form-inn-edit" action="{{ url('admin/inn_for_pet/'. $inn->id)  }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('put') }}
            <div class="box-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label">门店名称</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" style="width:70%;display:inline;" name="inn_name" id="inn_name" value="{{ $inn->inn_name }}"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">门店编号</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" style="width:70%;display:inline;" placeholder="所在市首字母大写+四位门店编号，例：SZ0185"  name="inn_sn" id="inn_sn" value="{{ $inn->inn_sn }}"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">是否直营</label>
                    <div class="col-sm-10">
                        <select class="form-control" style="width:70%;" name="is_self" >
                            <option id="is_self0" value="0">否</option>
                            <option id="is_self1" value="1" selected>是</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">门店电话</label>
                    <div class="col-sm-10">
                        <input type="tel" class="form-control" style="width:70%;display:inline;" placeholder="门店电话"  name="inn_tel" id="inn_tel" value="{{ $inn->inn_tel }}"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">门店详细地址</label>
                    <div class="col-sm-10">
                        <input type="tel" class="form-control" style="width:70%;display:inline;" placeholder="门店详细地址"  name="inn_address" id="inn_address" value="{{ $inn->inn_address }}"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">营业时间</label>
                    <div class="col-sm-10">
                        从
                        <input type="text" class="form-control start_time" style="width:30%;display:inline;" placeholder="营业开始时间" name="start_time" id="start_time"/>
                        营业到
                        <input type="text" class="form-control end_time" style="width:30%;display:inline;" placeholder="营业结束时间" name="end_time" id="end_time"/>
                        结束
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">门店状态</font></font></label>
                    <div class="col-sm-10">
                        <select class="form-control" style="width:70%;" name="inn_status">
                            <option id="inn_status-2" value="-2"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">拒绝</font></font></option>
                            <option id="inn_status-1" value="-1"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">已停止</font></font></option>
                            <option id="inn_status0" value="0" selected><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">未审核</font></font></option>
                            <option id="inn_status1" value="1"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">已通过</font></font></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">是否营业中</label>
                    <div class="col-sm-10">
                        <select class="form-control" style="width:70%;" name="is_running" >
                            <option id="is_running0" value="0">否</option>
                            <option id="is_running1" value="1" selected>是</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">所有者</label>
                    <div class="col-sm-10">
                        <input type="tel" class="form-control" style="width:70%;display:inline;" name="admin_id" id="admin_id" value="{{ $inn->admin_id }}"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">更新logo</label>
                    <div class="col-sm-10">
                        <a href="javascript:;" onclick="layer_show('上传头像','','350','350')" id="a-admin-avatar" class="btn-sm btn-primary">
                            选择文件
                        </a>
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
    <script type="text/javascript" src="{{ asset('plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
    <script>
        $(function(){
            $('.start_time').timepicker({
                defaultTime:'value="{{ $inn->start_time }}"',
                showMeridian:false,
            });
            $('.end_time').timepicker({
                defaultTime:'value="{{ $inn->end_time }}"',
                showMeridian:false,
            });
            $('#is_self{{$inn->is_self}}').attr('selected','selected');//自营选中
            $('#inn_status{{$inn->inn_status}}').attr('selected','selected');//自营选中
            $('#is_running{{$inn->is_running}}').attr('selected','selected');//自营选中
            /***编写Javascript表单验证区域*/
            $('#form-inn-edit').validate({
                rules:{//规则
                    inn_name:{
                        required:true,
                        rangelength:[1,12]
                    },
                    inn_sn:{
                        required:true,
                        rangelength:[5,12],
                    },
                    is_self:{
                        required:true,
                    },
                    inn_status:{
                        required:true,
                    },
                    is_running:{
                        required:true,
                    },
                    password:{
                        required:true,
                        rangelength:[5,20]
                    },
                    inn_tel:{
                        required:true,
                        rangelength:[11,11],
                        digits:true
                    },
                    inn_address:{
                        required:true,
                        rangelength:[10,52],
                    },
                    start_time:{
                        required:true,
                    },
                    end_time:{
                        required:true,
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
                            layer.msg('更新成功！', {
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
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
        <form class="form-horizontal" id="form-admin-add" action="{{ url('admin/inn_room')  }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="box-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label">房间编号</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" style="width:70%;display:inline;" placeholder="房间编号" name="room_number"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">所属店铺</label>
                    <div class="col-sm-10">
                        <select class="form-control" style="width:70%;" name="inn_id">
                            @foreach ($inn as $v)
                                <option value="{{ $v['id'] }}">
                                            {{ $v['inn_name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">是否可用</label>
                    <div class="col-sm-10">
                        <div class="col-sm-4 radio">
                            <label>
                                <input type="radio" name="is_enable" value="1" checked="">是
                            </label>
                        </div>
                        <div class="col-sm-6 radio">
                            <label>
                                <input type="radio" name="is_enable" value="0">否
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">房间类型</label>
                    <div class="col-sm-10">
                        <div class="col-sm-2 radio">
                            <label>
                                <input type="radio" name="room_type" value="-1">小型
                            </label>
                        </div>
                        <div class="col-sm-2 radio">
                            <label>
                                <input type="radio" name="room_type" value="0" checked="checked">普通
                            </label>
                        </div>
                        <div class="col-sm-2 radio">
                            <label>
                                <input type="radio" name="room_type" value="1" >大型
                            </label>
                        </div>
                        <div class="col-sm-2 radio">
                            <label>
                                <input type="radio" name="room_type" value="2" >豪华
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">上下铺</label>
                    <div class="col-sm-10">
                        <div class="col-sm-2 radio">
                            <label>
                                <input type="radio" name="bunk" value="-1" checked="checked">无
                            </label>
                        </div>
                        <div class="col-sm-2 radio">
                            <label>
                                <input type="radio" name="bunk" value="0" >下铺
                            </label>
                        </div>
                        <div class="col-sm-2 radio">
                            <label>
                                <input type="radio" name="bunk" value="1" >上铺
                            </label>
                        </div>
                        <div class="col-sm-2 radio">
                            <label>
                                <input type="radio" name="bunk" value="2" >上下贯通
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">排序权重</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" style="width:70%;display:inline;" placeholder="数值越大排名越前" id="sort_order" name="sort_order">
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
                    room_number:{
                        required:true,
                        rangelength:[2,12]
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
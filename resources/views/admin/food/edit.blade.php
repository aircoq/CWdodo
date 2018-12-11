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
        <form class="form-horizontal" id="form-table1" action="{{ url('admin/food/'.$food->id )  }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('put') }}
            <div class="box-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label">食物名称</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" style="width:70%;display:inline;" placeholder="食物名称" name="food_name" id="food_name" value="{{ $food->food_name }}"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">食物分类</label>
                    <div class="col-sm-10">
                        <select class="form-control" style="width:70%;" name="food_category" >
                            <option id="cate0" value="0">狗粮</option>
                            <option id="cate1" value="1">猫粮</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">适用年龄</label>
                    <div class="col-sm-10">
                        <select class="form-control" style="width:70%;" name="food_age" >
                            <option id="age0" value="0">离乳期</option>
                            <option id="age1" value="1">幼年</option>
                            <option id="age2" value="2">成年</option>
                            <option id="age3" value="3">老年</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">单价</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" style="width:70%;display:inline;" placeholder="元/天" name="price" value="{{ $food->price }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">排序权重</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" style="width:70%;display:inline;" placeholder="数值越大排名越前" id="sort_order" name="sort_order" value="{{ $food->sort_order }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">备注</label>
                    <div class="col-sm-10">
                        <textarea class="textarea" style="width: 70%; height: 150px; font-size: 14px;" placeholder="备注" name="mark_up">{{ $food->mark_up }}</textarea>
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
            $('#cate{{$food->food_category}}').attr('selected','selected');
            $('#age{{$food->food_age}}').attr('selected','selected');
            /***编写Javascript表单验证区域*/
            $("#form-table1").validate({
                rules:{//规则
                    type_name:{
                        required:true,
                        rangelength:[1,12]
                    },
                    mark_up:{
                        maxlength:200,
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
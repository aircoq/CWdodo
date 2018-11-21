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
        <form class="form-horizontal" id="form-admin-add" action="{{ url('admin/goods_attr/'.$goods_attr->id)  }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('put') }}
            <div class="box-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label">商品属性名称</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" style="width:70%;display:inline;" placeholder="商品类型名称" name="attr_name" id="attr_name" value="{{ $goods_attr->attr_name }}"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">商品类型</font></font></label>
                    <div class="col-sm-10">
                        <select class="form-control" style="width:70%;" name="type_id">
                            @foreach ($goods_type as $v)
                                <option value="{{ $v['id'] }}" id="goods_type{{ $v['id'] }}">
                                    <font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
                                            {{ $v['type_name'] }}
                                        </font></font>
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">属性类型</font></font></label>
                    <div class="col-sm-10">
                        <div class="col-sm-4 radio">
                            <label>
                                <input type="radio" name="attr_type" id="attr_type0" value="0" >单选
                            </label>
                        </div>
                        <div class="col-sm-6 radio">
                            <label>
                                <input type="radio" name="attr_type" id="attr_type1" value="1" >唯一
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">属性的录入方式</font></font></label>
                    <div class="col-sm-10">
                        <div class="col-sm-4 radio">
                            <label>
                                <input type="radio" name="attr_input_type" id="attr_input_type0" value="0" >手工录入
                            </label>
                        </div>
                        <div class="col-sm-6 radio">
                            <label>
                                <input type="radio" name="attr_input_type" id="attr_input_type1" value="1" >列表选择
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">属性可选值</label>
                    <div class="col-sm-10">
                        <textarea class="textarea" style="width: 70%; height: 50px; font-size: 14px;" placeholder="属性的可选值，当属性的录入方式为列表选择的时候对应的可选值，使用逗号进行分割" name="attr_values" id="attr_values">{{ $goods_attr->attr_values }}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">商品属性说明</label>
                    <div class="col-sm-10">
                        <textarea class="textarea" style="width: 70%; height: 50px; font-size: 14px;" placeholder="备注" name="note">{{ $goods_attr->note }}</textarea>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">排序权重</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" style="width:70%;display:inline;" placeholder="数值越大排名越前" id="sort_order" name="sort_order" value="{{ $goods_attr->sort_order }}">
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
            $('#goods_type{{ $goods_attr->type_id }}').attr('selected','selected');//父id选中
            $('#attr_type{{$goods_attr->attr_type}}').attr('checked','true');//是否显示
            $('#attr_input_type{{$goods_attr->attr_input_type}}').attr('checked','true');//是否显示
            @if($goods_attr->attr_input_type == 0)
                $("#attr_values").attr('disabled',true);
             @endif
            /***编写Javascript表单验证区域*/
            $("#form-admin-add").validate({
                rules:{//规则
                    attr_name:{
                        required:true,
                        rangelength:[1,12]
                    },
                    note:{
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
        //为属性的可选值做一个禁用操作
        $("input[name='attr_input_type']").click(function (event) {
            var input_value = $(this).val();
            if(input_value == 1){
                $("#attr_values").attr('disabled',false);
            }else {
                $("#attr_values").attr('disabled',true);
            }
        });
    </script>
@endsection
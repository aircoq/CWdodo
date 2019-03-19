@extends('admin.common.common')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('title')

@endsection

@section('css')
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}">
    <style>
        .ui-datepicker-today .ui-state-highlight{
            border: 1px solid #eee;
            color: #f60;
        }
        .ui-datepicker-current-day .ui-state-active{
            border: 1px solid #eee;
            color: #06f;
        }
        .error{color:red;}
    </style>
@endsection

@section('content')
    <form class="form-horizontal" id="form-add" action="{{ url('admin/service') }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <!-- /.box-header -->
        <!-- form start -->
        <input type="hidden" name="step" value="0"/>
        <div class="box-body">
            <div class="cl-sm-12">
                <div class="form-group">
                    <label class="col-sm-2 control-label">服务名称</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" style="width:70%;display:inline;" placeholder="服务名称" name="service_name"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">适用宠物</font></font></label>
                    <div class="col-sm-10">
                        <div class="col-sm-3 radio">
                            <label>
                                <input type="radio" name="pet_category" value="0">其他
                            </label>
                        </div>
                        <div class="col-sm-3 radio">
                            <label>
                                <input type="radio" name="pet_category" value="1" checked>狗
                            </label>
                        </div>
                        <div class="col-sm-3 radio">
                            <label>
                                <input type="radio" name="pet_category" value="2">猫
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">市场价格</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" style="width:70%;display:inline;" placeholder="市场价格" name="market_price"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">本店价格</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" style="width:70%;display:inline;" placeholder="本店价格" name="shop_price"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">是否开放售卖</font></font></label>
                    <div class="col-sm-10">
                        <div class="col-sm-4 radio">
                            <label>
                                <input type="radio" name="is_on_sale" value="1" checked>是
                            </label>
                        </div>
                        <div class="col-sm-6 radio">
                            <label>
                                <input type="radio" name="is_on_sale" value="0">否
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
                <div class="form-group">
                    <label class="col-sm-2 control-label">详情图1(必填)</label>
                    <div class="col-sm-10">
                        <input type="file" accept="image/png, image/jpeg, image/gif, image/jpg" class="filepath" onchange="changepic(this)" name="service_thumb"/><font style="color: red">只能上传高宽各为800，不超过550K的图片</font><br/>
                        <img src=""/>
                    </div>
                </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <label class="col-sm-2 control-label"></label>
                <div class="col-sm-10">
                    <input type="submit" class="btn btn-primary radius" value="确认提交"/>
                </div>
            </div>
        </div>
    </form>
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
            $("#form-add").validate({
                rules:{//规则
                    service_name:{
                        required:true,
                        rangelength:[1,15]
                    },
                    cate_id:{
                        digits:true
                    },
                    type_id:{
                        digits:true
                    },
                    brand_id:{
                        digits:true
                    },
                    inventory:{
                        digits:true
                    },
                    warn_num:{
                        digits:true
                    },
                    is_real:{
                        range:[0,1]
                    },
                    integral:{
                        digits:true
                    },
                    sort_order:{
                        digits:true
                    },
                    give_integral:{
                        digits:true
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        /** 上传图片时生成图片预览 */
        function changepic(obj) {
            var newsrc=getObjectURL(obj.files[0]);
            console.log(obj.id);
            $(obj).siblings('font').remove();
            $(obj).siblings('img').attr({"src":newsrc,height:200,width:200});
        }
        //建立一个可存取到file的url
        function getObjectURL(file) {
            var url = null ;
            // 针对不同浏览器获得url的方法
            if (window.createObjectURL!=undefined) { // basic
                url = window.createObjectURL(file) ;
            } else if (window.URL!=undefined) { // mozilla(firefox)
                url = window.URL.createObjectURL(file) ;
            } else if (window.webkitURL!=undefined) { // webkit or chrome
                url = window.webkitURL.createObjectURL(file) ;
            }
            return url ;
        }
    </script>
@endsection
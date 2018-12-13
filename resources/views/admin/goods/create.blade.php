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
    <form class="form-horizontal" id="form-add" action="{{ url('admin/goods') }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <!-- /.box-header -->
        <!-- form start -->
        <input type="hidden" name="step" value="0"/>
        <div class="box-body">
            <div class="cl-sm-12">
                <div class="form-group">
                    <label class="col-sm-2 control-label">商品名称</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" style="width:70%;display:inline;" placeholder="商品类型名称" name="goods_name"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">所属分类</font></font></label>
                    <div class="col-sm-10">
                        <select class="form-control" style="width:70%;" name="cate_id">
                            @foreach ($goods_category as $v)
                                <option value="{{ $v['id'] }}">
                                    <font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
                                            <?php
                                            for ($i=$v['path'];$i>0;$i--){
                                                echo '&nbsp&nbsp&nbsp&nbsp&nbsp';
                                            }
                                            ?>
                                            {{ $v['cate_name'] }}
                                        </font></font>
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">商品类型</font></font></label>
                    <div class="col-sm-10">
                        <select class="form-control" style="width:70%;" name="type_id">
                            @foreach ($goods_type as $v)
                                <option value="{{ $v['id'] }}">
                                    <font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
                                            {{ $v['type_name'] }}
                                        </font></font>
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">商品品牌</font></font></label>
                    <div class="col-sm-10">
                        <select class="form-control" style="width:70%;" name="brand_id">
                            @foreach ($goods_brand as $v)
                                <option value="{{ $v['id'] }}">
                                    <font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
                                            {{ $v['brand_name'] }}
                                        </font></font>
                                </option>
                            @endforeach
                        </select>
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
                    <label class="col-sm-2 control-label">促销价格</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" style="width:70%;display:inline;" placeholder="促销时启用的价格" name="promote_price"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">促销时间段</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" style="width:34.855%;display:inline;" placeholder="促销开始时间" name="promote_start_at"/>
                        <input type="text" class="form-control" style="width:34.855%;display:inline;" placeholder="促销结束时间" name="promote_end_at"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">商品库存</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" style="width:70%;display:inline;margin-right:3.6%" placeholder="商品库存" name="inventory"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">报警数量</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" style="width:70%;display:inline;margin-right:3.6%" placeholder="商品库存" name="warn_num"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">商品重量（kg）</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" style="width:70%;display:inline;" placeholder="商品重量（kg）" name="goods_weight"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">是否是实物</font></font></label>
                    <div class="col-sm-10">
                        <div class="col-sm-4 radio">
                            <label>
                                <input type="radio" name="is_real" value="1">是
                            </label>
                        </div>
                        <div class="col-sm-6 radio">
                            <label>
                                <input type="radio" name="is_real" value="0">否
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">是否开放售卖</font></font></label>
                    <div class="col-sm-10">
                        <div class="col-sm-4 radio">
                            <label>
                                <input type="radio" name="is_on_sale" value="1">是
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
                    <label class="col-sm-2 control-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">能否单独售卖</font></font></label>
                    <div class="col-sm-10">
                        <div class="col-sm-4 radio">
                            <label>
                                <input type="radio" name="is_alone_sale" value="1">是
                            </label>
                        </div>
                        <div class="col-sm-6 radio">
                            <label>
                                <input type="radio" name="is_alone_sale" value="0">否
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">是否精品</font></font></label>
                    <div class="col-sm-10">
                        <div class="col-sm-4 radio">
                            <label>
                                <input type="radio" name="is_best" value="1">是
                            </label>
                        </div>
                        <div class="col-sm-6 radio">
                            <label>
                                <input type="radio" name="is_best" value="0">否
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">是否新品</font></font></label>
                    <div class="col-sm-10">
                        <div class="col-sm-4 radio">
                            <label>
                                <input type="radio" name="is_new" value="1">是
                            </label>
                        </div>
                        <div class="col-sm-6 radio">
                            <label>
                                <input type="radio" name="is_new" value="0">否
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">是否热销</font></font></label>
                    <div class="col-sm-10">
                        <div class="col-sm-4 radio">
                            <label>
                                <input type="radio" name="is_hot" value="1">是
                            </label>
                        </div>
                        <div class="col-sm-6 radio">
                            <label>
                                <input type="radio" name="is_hot" value="0">否
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">是否特价促销</font></font></label>
                    <div class="col-sm-10">
                        <div class="col-sm-4 radio">
                            <label>
                                <input type="radio" name="is_promote" value="1">是
                            </label>
                        </div>
                        <div class="col-sm-6 radio">
                            <label>
                                <input type="radio" name="is_promote" value="0">否
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">所需积分</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" style="width:70%;display:inline;" placeholder="购买商品所需的积分" name="integral">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">奖励积分</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" style="width:70%;display:inline;" placeholder="交易成功获取的积分" name="give_integral">
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
                        <input type="file" accept="image/png, image/jpeg, image/gif, image/jpg" class="filepath" onchange="changepic(this)" name="goods_img1"/><font style="color: red">只能上传高宽各为800，不超过550K的图片</font><br/>
                        <img src=""/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">详情图2</label>
                    <div class="col-sm-10">
                        <input type="file" accept="image/png, image/jpeg, image/gif, image/jpg" class="filepath" onchange="changepic(this)" name="goods_img2"/><font style="color: red">只能上传高宽各为800，不超过550K的图片</font><br>
                        <img src=""/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">详情图3</label>
                    <div class="col-sm-10">
                        <input type="file" accept="image/png, image/jpeg, image/gif, image/jpg" class="filepath" onchange="changepic(this)" name="goods_img3"/><font style="color: red">只能上传高宽各为800，不超过550K的图片</font><br>
                        <img src="" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">详情图4</label>
                    <div class="col-sm-10">
                        <input type="file" accept="image/png, image/jpeg, image/gif, image/jpg" class="filepath" onchange="changepic(this)" name="goods_img4"/><font style="color: red">只能上传高宽各为800，不超过550K的图片</font><br>
                        <img src="" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">详情图5</label>
                    <div class="col-sm-10">
                        <input type="file" accept="image/png, image/jpeg, image/gif, image/jpg" class="filepath" onchange="changepic(this)" name="goods_img5"/><font style="color: red">只能上传高宽各为800，不超过550K的图片</font><br>
                        <img src="" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">详情图6</label>
                    <div class="col-sm-10">
                        <input type="file" accept="image/png, image/jpeg, image/gif, image/jpg" class="filepath" onchange="changepic(this)" name="goods_img6"/><font style="color: red">只能上传高宽各为800，不超过550K的图片</font><br>
                        <img src="" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">商品描述</label>
                    <div class="col-sm-10">
                        <textarea id="goods_desc" name="goods_desc" rows="10" cols="5" ></textarea>
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
    <!-- bootstrap datetimepicker -->
    <script src="{{ asset('bower_components/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{ asset('bower_components/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js')}}"></script>
    <!-- CK Editor -->
    <script src="{{ asset('bower_components/ckeditor/ckeditor.js')}}"></script>
    <script src="{{ asset('bower_components/ckeditor/config.js')}}"></script>
    <script src="{{ asset('bower_components/ckeditor/lang/zh-cn.js')}}"></script>
    <script>
        $(function(){
            /***时间插件*/
            $("input[name='promote_start_at']").datetimepicker({
                language: "zh-CN",
                autoclose: true,//选中之后自动隐藏日期选择框
                clearBtn: true,//清除按钮
                todayBtn: true,//今日按钮
                todayHighlight: true,
                format: "yyyy-mm-dd hh:ii"
            });
            $("input[name='promote_end_at']").datepicker({
                language: "zh-CN",
                autoclose: true,//选中之后自动隐藏日期选择框
                clearBtn: true,//清除按钮
                todayBtn: true,//今日按钮
                todayHighlight: true,
                format: "yyyy-mm-dd hh:ii"
            });
            /***配置富文本编辑器*/
            CKEDITOR.replace('goods_desc',{//实例化插件
                height: 450,
                filebrowserImageUploadUrl : '{{url('/admin/goods/image_upload')}}',
                removePlugins:'elementspath,resize',
                codeSnippet_theme: 'zenburn',

            });
            /***编写Javascript表单验证区域*/
            $("#form-add").validate({
                rules:{//规则
                    goods_name:{
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
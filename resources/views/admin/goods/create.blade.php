@extends('admin.common.common')

@section('title')

@endsection

@section('css')
    <style>
        .error{color:red;}
    </style>
@endsection

@section('content')
    <div class="cl-xs-12">
        <!-- /.box-header -->
        <!-- form start -->
        <form class="form-horizontal" id="form-admin-add" action="{{ url('admin/goods')  }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="box-body">
                <div class="form-group">
                    <label class="col-xs-2 control-label">商品名称</label>
                    <div class="col-xs-10">
                        <input type="text" class="form-control" style="width:70%;display:inline;" placeholder="商品类型名称" name="type_name" id="type_name"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">商品类型</font></font></label>
                    <div class="col-sm-10">
                        <select class="form-control" style="width:70%;" name="p_id">
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
                    <label class="col-sm-2 control-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">所属分类</font></font></label>
                    <div class="col-sm-10">
                        <select class="form-control" style="width:70%;" name="p_id">
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
                    <label class="col-xs-2 control-label">市场价格</label>
                    <div class="col-xs-10">
                        <input type="text" class="form-control" style="width:70%;display:inline;" placeholder="商品价格" name="type_name"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-2 control-label">本店价格</label>
                    <div class="col-xs-10">
                        <input type="text" class="form-control" style="width:70%;display:inline;" placeholder="商品类型名称" name="type_name"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-2 control-label">促销价格</label>
                    <div class="col-xs-10">
                        <input type="text" class="form-control" style="width:70%;display:inline;" placeholder="商品类型名称" name="type_name"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-2 control-label">商品库存</label>
                    <div class="col-xs-10">
                        <input type="text" class="form-control" style="width:70%;display:inline;" placeholder="商品类型名称" name="type_name"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-2 control-label">报警数量</label>
                    <div class="col-xs-10">
                        <input type="text" class="form-control" style="width:70%;display:inline;" placeholder="商品类型名称" name="type_name"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-2 control-label">商品重量（kg）</label>
                    <div class="col-xs-10">
                        <input type="text" class="form-control" style="width:70%;display:inline;" placeholder="不填写则系统自动生成" name="type_name"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-2 control-label">市场价</label>
                    <div class="col-xs-10">
                        <input type="text" class="form-control" style="width:70%;display:inline;" placeholder="不填写则系统自动生成" name="type_name"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-2 control-label">本店价</label>
                    <div class="col-xs-10">
                        <input type="text" class="form-control" style="width:70%;display:inline;" placeholder="不填写则系统自动生成" name="type_name"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-2 control-label">促销价</label>
                    <div class="col-xs-10">
                        <input type="text" class="form-control" style="width:70%;display:inline;" placeholder="不填写则系统自动生成" name="type_name"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-2 control-label">促销时间</label>
                    <div class="col-xs-10">
                        <input type="text" class="form-control" style="width:70%;display:inline;" placeholder="不填写则系统自动生成" name="type_name"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">是否是实物</font></font></label>
                    <div class="col-sm-10">
                        <div class="col-sm-4 radio">
                            <label>
                                <input type="radio" name="" value="1">是
                            </label>
                        </div>
                        <div class="col-sm-6 radio">
                            <label>
                                <input type="radio" name="" value="0">否
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">是否是实物</font></font></label>
                    <div class="col-sm-10">
                        <div class="col-sm-4 radio">
                            <label>
                                <input type="radio" name="" value="1">是
                            </label>
                        </div>
                        <div class="col-sm-6 radio">
                            <label>
                                <input type="radio" name="" value="0">否
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">是否开放售卖</font></font></label>
                    <div class="col-sm-10">
                        <div class="col-sm-4 radio">
                            <label>
                                <input type="radio" name="" value="1">是
                            </label>
                        </div>
                        <div class="col-sm-6 radio">
                            <label>
                                <input type="radio" name="" value="0">否
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">能否单独售卖</font></font></label>
                    <div class="col-sm-10">
                        <div class="col-sm-4 radio">
                            <label>
                                <input type="radio" name="" value="1">是
                            </label>
                        </div>
                        <div class="col-sm-6 radio">
                            <label>
                                <input type="radio" name="" value="0">否
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">是否精品</font></font></label>
                    <div class="col-sm-10">
                        <div class="col-sm-4 radio">
                            <label>
                                <input type="radio" name="" value="1">是
                            </label>
                        </div>
                        <div class="col-sm-6 radio">
                            <label>
                                <input type="radio" name="" value="0">否
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">是否新品</font></font></label>
                    <div class="col-sm-10">
                        <div class="col-sm-4 radio">
                            <label>
                                <input type="radio" name="" value="1">是
                            </label>
                        </div>
                        <div class="col-sm-6 radio">
                            <label>
                                <input type="radio" name="" value="0">否
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">是否热销</font></font></label>
                    <div class="col-sm-10">
                        <div class="col-sm-4 radio">
                            <label>
                                <input type="radio" name="" value="1">是
                            </label>
                        </div>
                        <div class="col-sm-6 radio">
                            <label>
                                <input type="radio" name="" value="0">否
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">是否特价促销</font></font></label>
                    <div class="col-sm-10">
                        <div class="col-sm-4 radio">
                            <label>
                                <input type="radio" name="" value="1">是
                            </label>
                        </div>
                        <div class="col-sm-6 radio">
                            <label>
                                <input type="radio" name="" value="0">否
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">所需积分</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" style="width:70%;display:inline;" placeholder="" name="sort_order">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">奖励积分</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" style="width:70%;display:inline;" placeholder="" name="sort_order">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">排序权重</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" style="width:70%;display:inline;" placeholder="数值越大排名越前" id="sort_order" name="sort_order">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-2 control-label">商品重量（kg）</label>
                    <div class="col-xs-10">
                        <input type="text" class="form-control" style="width:70%;display:inline;" placeholder="不填写则系统自动生成" name="type_name"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-2 control-label">商品类型说明</label>
                    <div class="col-xs-10">
                        <textarea class="textarea" style="width: 70%; height: 150px; font-size: 14px;" placeholder="商品描述" name="goods_desc"></textarea>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <label class="col-xs-2 control-label"></label>
                <div class="col-xs-10">
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